<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\User;
use App\Models\Business;
use App\Models\Webhooks;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use App\Models\Orders;
use App\Models\Plans;
use App\Models\Invoices;
use App\Models\Products;
use App\Models\Subscriptions;
use App\Models\ControlCategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DiscordController;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;


class StripeController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $request)
    {
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => 100 * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => ""
        ]);

        Session::flash('success', 'Payment successful!');

        return back();
    }
    protected function stripeSuccess(Request $request)
    {
        $user = json_decode(Cookie::get('user'));
        $user = $user->user;
        $user_id = $user->id;

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $stripe_detail = $stripe->checkout->sessions->retrieve(
            $request->session_id,
            []
        );

        $subscription_d = $stripe->subscriptions->retrieve(
            $stripe_detail->subscription,
            []
        );

        $subscription = new Subscriptions();
        $subscription->user = $user_id;
        $subscription->server_id = '1';
        $subscription->stripe_sid = $subscription_d->id;
        $subscription->stripe_pid = $subscription_d->plan->id;
        $subscription->plan = '1';
        $subscription->Amount = $subscription_d->plan->amount;
        $subscription->status = $subscription_d->status;
        $subscription->creationDate = date('Y-m-d H:i:s', $subscription_d->start);
        $subscription->endDate = date('Y-m-d H:i:s', $subscription_d->start_date);

        $subscription->save();
        session()->put('success', 'Subscription created successfully.');
        return view('thank-you');
    }

    public function thankYou()
    {
        return view('thank-you');
    }

    public function stripeProduct(Request $request)
    {
        $product_exist = DB::table('products')
            ->where([
                'name' => $request->prod_name,
            ])->first();

        if (!$product_exist) {
            // $request->validate([
            //     'prod_name'     => 'required',
            //     'prod_interval' => 'required',
            //     'prod_amount'   => 'required',
            //     'product_cate'  => 'required',
            //     'product_status'=> 'required',
            //     'prod_descr'   => 'required',
            //     'trial_day'     => 'max:750'
            // ]);


            $stripe = new \Stripe\StripeClient(config('stripe.secret'));

            $product = $stripe->products->create([
                'name' => $request->prod_name,
            ]);
            $product_id = $product->id;

            $price = $stripe->prices->create([
                'unit_amount' => (int)$request->prod_amount * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => 'month'],
                'product' => $product_id,
            ]);

            $price_id = $price->id;

            $product = new Products();
            $product->category_id = 1;
            $product->name = $request->prod_name;
            $product->description = $request->prod_descr;
            $product->price = $request->prod_amount;
            $product->stripeProduct = $product_id;
            $product->stripePid = $price_id;
            $product->trial_period = $request->trial_day;
            $product->visible = $request->product_status;
            $product->trial = $request->trial_status;
            $product->channel_type = $request->product_type;

            $product->save();
            if ($request->category_id !== null && $request->category_id !== "") {
                $category = ControlCategories::create([
                    'product' => $product->id,
                    "categoryId" => $request->category_id,
                    "type" => $request->product_type,
                ]);
                $info_request = "" . env('BOT_API_URL') . "/get_monitor";
                $data = [
                    'monitor' => $request->category_id
                ];
                $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
                $response->throw();
            }
            session()->put('success', 'Record added successfully.');
            return redirect('admin/products');
        } else {
            session()->put('danger', 'Record already exists.');
            return back();
        }
    }

    public function deleteProduct($id)
    {

        $check = Products::where('id', '=', $id)->delete();
        Session::flash('success', 'Product deleted successfully.');
        return back();
    }
    public function subscriptionCancel(Request $request)
    {
        if (!$request->bearerToken()) {
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }

        $business = Business::where('api_token', $request->bearerToken())->first();
        if (!$business) {
            return [
                "status" => "error",
                "message" => "Business not found"
            ];
        }
        if (!$request->product) {
            return [
                "status" => "error",
                "message" => "Invalid Product"
            ];
        }
        $product = Products::where('id', $request->product)->first();

        if (!$product) {
            return [
                "status" => "error",
                "message" => "Product not found"
            ];
        }
        $subscriptionObject = Subscriptions::where([
            ['business', '=', $business->id],
            ['product', '=', $product->id]
        ])->first();

        if (!$subscriptionObject) {
            return [
                "status" => "error",
                "message" => "Subscription not found"
            ];
        }

        $stripe = new \Stripe\StripeClient(config('stripe.secret'));

        $cancelEvent = $stripe->subscriptions->cancel($subscriptionObject->stripe_sid);

        $planObj = Plans::where('subscription', "=", $subscriptionObject->id)->first();

        if ($product->price == 0){
            $planObj->enabled = 0;
            $planObj->cancel = 1;
        } else {
            $planObj->cancel = 1;
        }

        $planObj->save();

        return [
            "status" => "success",
            "message" => "Subscription cancelled"
        ];
    }

    public function subscriptionResubscribe(Request $request){

    }
    
    public function subscriptionCheckout(Request $request)
    {
        if (!$request->bearerToken()) {
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }

        if (!$request->token) {
            return [
                "status" => "error",
                "message" => "Missing Business Token"
            ];
        }
        $user = User::where('api_token', $request->bearerToken())->first();
        if (!$user) {
            return [
                "status" => "error",
                "message" => "User not found"
            ];
        }
        $business = Business::where('api_token', $request->token)->first();
        if (!$business) {
            return [
                "status" => "error",
                "message" => "Business not found"
            ];
        }
        if (!$request->product) {
            return [
                "status" => "error",
                "message" => "Invalid Product"
            ];
        }
        $product = Products::where('id', $request->product)->first();

        if (!$product) {
            return [
                "status" => "error",
                "message" => "Product not found"
            ];
        }
        if (!$product->stripePid && $product->price != 0) {
            return [
                "status" => "error",
                "message" => "Product has a missing stripe id"
            ];
        }

        if ($product->price == 0) {
            $matchThese = [["product", "=", $product->id], ["business", '=', $business->id]];
            $checkPlans = Plans::where($matchThese)->first();
            if ($checkPlans){
                $planId = $checkPlans->id;
                $checkPlans->enabled = 1;
                $checkPlans->save();
                if($product->channel_type == 1){
                        $checkPlans->channels()->delete();
                } else {
                        $checkPlans->webhooks()->delete();
                }
            } else {

                $createPlan = Plans::create([
                    "product" => $product->id,
                    "user" => $user->id,
                    "business" => $business->id
                ]);
                $planId = $createPlan->id;
            }

            if ($product->channel_type == 1) {
                $info_request = "" . env('BOT_API_URL') . "/create_monitor";
                $data = [
                    'monitor' => $planId
                ];
                $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
                $response->throw();
                $guilds = json_decode($response->getbody(), true);
            }
            $info_request = "" . env('BOT_API_URL') . "/send_announcement";
            $data = [
                'guild' => $business->server->guild_id,
                "message" => "Welcome to mocean"
            ];
            $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
            return [
                "status" => "success",
                "checkout_link" => "https://mocean.info/manage/" . $product->id
            ];
        }

        $stripe = new \Stripe\StripeClient(config('stripe.secret'));

        $user_id = $user->id;
        $stripe_customer_id = $user->stripe_customer;

        if (is_null($user->stripe_customer) || $user->stripe_cust_id == "") {
            $stripe_customer = $stripe->customers->create([
                'email' => $user->email,
            ]);
            $stripe_customer_id = $stripe_customer->id;
            $user->stripe_customer = $stripe_customer_id;
            $user->save();
        }


        $YOUR_DOMAIN = env('FRONTEND_URL', 'http://localhost:3000');
        $YOUR_DOMAIN2 = env('FRONTEND_URL', 'http://localhost:3000') . '/success/' . $product->id;
        try {
            if ($product->trial == true && $product->trial_period > 0) {
                $timestamp = time() + (60 * 60 * 24 * ($product->trial_period + 1));

                $checkout_session = $stripe->checkout->sessions->create([
                    'line_items' => [[
                        'price' => $product->stripePid,
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'allow_promotion_codes' => true,
                    'billing_address_collection' => 'required',
                    'customer_update' => [
                        "name" => 'auto',
                        "address" => 'auto'
                    ],
                    'success_url' => $YOUR_DOMAIN,
                    'cancel_url' => $YOUR_DOMAIN,
                    'customer' => $stripe_customer_id,
                    'metadata' => [
                        'user' => $user->id,
                        'business' => $business->id,
                        'discord' => $user->discord_id,
                        'product' => $product->id
                    ],
                    'subscription_data' => [
                        "trial_end" => $timestamp
                    ]

                ]);
            } else {
                $checkout_session = $stripe->checkout->sessions->create([
                    'line_items' => [[
                        'price' => $product->stripePid,
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'allow_promotion_codes' => true,
                    'billing_address_collection' => 'required',
                    'customer_update' => [
                        "name" => 'auto',
                        "address" => 'auto'
                    ],
                    'success_url' => $YOUR_DOMAIN,
                    'cancel_url' => $YOUR_DOMAIN,
                    'customer' => $stripe_customer_id,
                    'metadata' => [
                        'user' => $user->id,
                        'business' => $business->id,
                        'discord' => $user->discord_id,
                        'product' => $product->id
                    ],
                    'subscription_data' => []
                ]);
            }
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => "Error creating subscription"
            ];
        }
        return [
            "status" => "success",
            "checkout_link" => $checkout_session->url
        ];
    }

    public function createPortalLink(Request $request)
    {
        if (!$request->bearerToken()) {
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }

        if (!$request->token) {
            return [
                "status" => "error",
                "message" => "Missing Business Token"
            ];
        }
        $user = User::where('api_token', $request->bearerToken())->first();
        if (!$user) {
            return [
                "status" => "error",
                "message" => "User not found"
            ];
        }
        $business = Business::where('api_token', $request->token)->first();
        if (!$business) {
            return [
                "status" => "error",
                "message" => "Business not found"
            ];
        }

        $stripe = new \Stripe\StripeClient(config('stripe.secret'));
        $stripe_customer_id = $user->stripe_customer;

        if (is_null($user->stripe_customer) || $user->stripe_customer == "") {
            $stripe_customer = $stripe->customers->create([
                'email' => $user->email,
            ]);
            $stripe_customer_id = $stripe_customer->id;
            $user->stripe_customer = $stripe_customer_id;
            $user->save();
        }
        $session = $stripe->billingPortal->sessions->create([
            'customer' => $stripe_customer_id,
            'return_url' => env('FRONTEND_URL', 'http://localhost:3000') . '/account',
        ]);

        return [
            "status" => "success",
            "checkout_link" => $session->url
        ];
        // header("Location: " . $session->url);
        // exit();
    }

    public function subscriptionCreate(Request $request)
    {

        $user = json_decode(Cookie::get('user'));
        $user = $user->user;
        $user_id = $user->id;
        $stripe_customer_id = $user->stripe_cust_id;

        $token =  $request->stripeToken;
        // $paymentMethod = $request->paymentMethod;
        try {

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            if (is_null($user->stripe_cust_id) || $user->stripe_cust_id == "") {
                $stripe_customer = $stripe->customers->create([
                    'email' => $user->email,
                ]);
                $stripe_customer_id = $stripe_customer->id;
            }

            $source = $stripe->customers->createSource(
                $stripe_customer_id,
                ['source' => $token]
            );

            $user_subscription = $stripe->subscriptions->create([
                'customer' => $stripe_customer_id,
                'items' => [
                    ['price' => 'plan_LqRn8sv74zt0Zp'],
                ],
            ]);
            // dd($user_subscription);

            $product = new Subscriptions();
            $product->user = $user_id;
            $product->server_id = '1';
            $product->stripe_sid = $user_subscription->id;
            $product->stripe_pid = 'plan_LqRn8sv74zt0Zp';
            $product->plan = '1';
            $product->creationDate = date('Y-m-d h:i:s', strtotime($user_subscription->start));
            $product->endDate = date('Y-m-d h:i:s', strtotime($user_subscription->start_date));

            $product->save();

            return back()->with('success', 'Subscription is completed.');
        } catch (Exception $e) {
            report($e);
            return back()->with('error', 'An error occurred processing your subscription. Please try again.');
        }
    }

    public function mrrReport(Request $request)
    {
        // $mrr_count = plans()
        // ->select(DB::raw('SUM(price) as total_amount'));
        // ->groupBy(DB::raw('MONTH(create_at) ASC'))->get();
        // return view('product')->with($mrr_count);
    }

    public function Dashboard(Request $request)
    {


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient();

        $userCount = User::count();
        $webhooksCount = Webhooks::count();
        $products = Products::where("visible", "=", 1)->count();
        $monitorsRunning = Plans::count();
        $invoices = Invoices::orderBy('id', 'desc')->take(5)->get();
        $mrr = Subscriptions::all()->sum('pay_amount');
        return view('index', ['userCount' => $userCount, "mrr" => $mrr, 'webhooksCount' => $webhooksCount, 'stripe' => $stripe, 'orders' => $invoices, 'products' => $products, "monitorsRunning" => $monitorsRunning]);
    }


    public static function getPrices(Products $product)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.secret'));
        try {
            return $stripe->prices->all(["product" => $product->stripeProduct]);
        } catch (\Exception $e) {
            return [];
        }
    }
}
