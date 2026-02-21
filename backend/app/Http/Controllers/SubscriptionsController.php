<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Plans;
use App\Models\Invoices;
use App\Models\Products;
use App\Models\Servers;
use App\Models\ClientChannels;
use App\Models\Channels;
use App\Models\Business;
use App\Models\Subscriptions;
use App\Providers\RouteServiceProvider;
use Storage;
use Stripe;


class SubscriptionsController extends Controller
{

    //Connection instance

    // table name
    private $table_name="user-subscriptions";

    // table columns
    public $id;
    public $sever_id;
    public $stripe_sid;
    public $stripe_pid;
    public $plan;
    public $creation_date;
    public $join_date;



    public function index()
    {
        return Subscriptions::all();
    }

    public function show(Subscriptions $subscriptions)
    {
        return $subscriptions;
    }
    public function getId($id){
        return Subscriptions::find($id);
    }
    public function getServer($server_id){
        return Subscription::where('server_id', $server_id );
    }

    public function store(Request $request)
    {
        $validated = $request->only(['product', 'user', 'business', 'stripe_sid', 'stripe_pid', 'pay_amount', 'endDate']);
        $subscriptions = Subscriptions::create($validated);

        return response()->json($subscriptions, 201);
    }

    public function update(Request $request, Subscriptions $subscriptions)
    {
        $validated = $request->only(['pay_amount', 'endDate']);
        $subscriptions->update($validated);
        return response()->json($subscriptions, 200);

    }

    public function delete(Subscriptions $subscriptions)
    {
        $subscriptions -> delete();
        return response()-> json(null, 204);
    }

    public function webhookResponse(Request $request)
    {

        // Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // require 'vendor/autoload.php';


        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
          $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
          );
        } catch(\UnexpectedValueException $e) {
          // Invalid payload
          http_response_code(400);
          exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
          // Invalid signature
          http_response_code(400);
          exit();
        }

        // Handle the event
	switch ($event->type) {
            case 'checkout.session.completed':
                $stripe = new \Stripe\StripeClient(config('stripe.secret'));
                $session = $event->data->object;
                $metadata = $session->metadata;
                $checkForExistingSub = Subscriptions::where('stripe_sid', '=', $session->subscription)->first();
                if ($checkForExistingSub) break;
		$grabSub = $stripe->subscriptions->retrieve($session->subscription, ["expand"=>["default_payment_method"]]);
                $grabInv = $stripe->invoices->retrieve($grabSub["latest_invoice"]);
                $user = User::where('id', '=', $metadata->user)->first();
		if(!$user) break;
                $user->stripe_id = $session->customer->id ?? null;
                $user->customer_email = $session->customer_email ?? null;
                $user->customer_name = $session->customer_details->name ?? null;
                $user->pm_last_four = $grabSub->default_payment_method->card->last4 ?? null;
		$user->save();
                $business = Business::where('id', '=', $metadata->business)->first();
                $product = Products::where('id', '=', $metadata->product)->first();
                $grabSub = $stripe->subscriptions->retrieve($session->subscription);
                $grabInv = $stripe->invoices->retrieve($grabSub["latest_invoice"]);
                $createSubscription = Subscriptions::create([
                    "product" => $product->id,
                    "user" => $user->id,
                    "business" => $business->id,
                    "stripe_sid" => $session->subscription,
                    "stripe_pid" => $grabInv->payment_intent ?? null,
                    "pay_amount" => $session->amount_total/100,
                    "endDate" => date('Y-m-d H:i:s', $grabSub["current_period_end"])
                ]);
		$matchThese = [["product", "=", $product->id], ["business", '=', $business->id]];
                $checkPlans = Plans::where($matchThese)->first();
                if ($checkPlans){
                    $planId = $createPlans->id;
                    if($product->channel_type == 1){
                            $checkPlans->channels()->delete();
                    } else {
                            $checkPlans->webhooks()->delete();
                    }
                    $checkPlans->user = $user->id;
                    $checkPlans->subscription = $createSubscription->id;
                    $checkPlans->hadTrial = ($grabSub["trial_end"] !== null ? 1 : 0);
                    $checkPlans->activeTrial = ($grabSub["trial_end"] !== null ? 1 : 0);
                    $checkPlans->trialEndDate = date('Y-m-d H:i:s', $grabSub["trial_end"]) ?? null;
                    $checkPlans->endDate = date('Y-m-d H:i:s', $grabSub["current_period_end"]);
                    $checkPlans->enabled = 1;
                    $checkPlans->save();
                } else {
                    $createPlan = Plans::create([
                        "product" => $product->id,
                        "user" => $user->id,
                        "business" => $business->id,
                        "subscription" => $createSubscription->id,
                        "hadTrial" => ($grabSub["trial_end"] !== null ? 1 : 0),
                        "activeTrial" => ($grabSub["trial_end"] !== null ? 1 : 0),
                        "trialEndDate" => date('Y-m-d H:i:s', $grabSub["trial_end"]) ?? null,
                        "endDate" => date('Y-m-d H:i:s', $grabSub["current_period_end"])
                    ]);
                    $planId = $createPlan->id;
                }
		sleep(5);
                if($product->channel_type==1){
                    $info_request = "" . env('BOT_API_URL') . "/create_monitor";
                    $data = [
                        'monitor' => $planId
                    ];
                    $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
                    //$response->throw();
                    $guilds = json_decode($response->getbody(), true);
                }
		$info_request = "" . env('BOT_API_URL') . "/send_announcement";
                $data = [
                    'guild_id' => $business->server->guild_id,
                    "message" => "Welcome to Mocean!\n\nThank you for purchasing. We hope that this has been a smooth process and that you are enjoying your services so far. If you have any questions, suggestions, or if something isn't working correctly, please feel free to open a support ticket in our Discord server: https://discord.com/invite/mocean. If you would like to cancel your services, you can do so through your the individual product page for that particular service."
                ];
                $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
                //$response->throw();
                $guilds = json_decode($response->getbody(), true);
                break;

            case 'invoice.finalized':
                $session = $event->data->object;
		sleep(4);
                $subscription = Subscriptions::where('stripe_sid', '=', $session->subscription)->first();
                if(!$subscription){
                    return;
                }
		$plan = Plans::where('subscription', '=', $subscription->id)->first();
                if ($session->amount_due >= 0) {
                    Invoices::create([
                        "user"=>$subscription->user,
                        "business"=>$subscription->business,
                        "product"=>$subscription->product,
                        "plan"=>$plan->id,
                        "sub"=>$subscription->id,
                        "stripe_tid"=>$session->id,
                        "billing_name" =>$session->customer_name,
                        "billing_address" => $session->customer_address->line1.", ".$session->customer_address->city.", ".$session->customer_address->state." ".$session->customer_address->postal_code.", ".$session->customer_address->country,
                        "billing_email" =>$session->customer_email,
			"invoice_url" =>$session->lines->url,
                        "pay_amount"=>$session->amount_due/100 ?? 0,
                        "paid"=>0
                    ]);
                    $plan->activeTrial = 0;
                    $plan->save();
                }
                break;

            case 'invoice.payment_succeeded':
                $stripe = new \Stripe\StripeClient(config('stripe.secret'));
                $session = $event->data->object;
		sleep(5);
                if ($session->amount_due >= 0) {
                    if ($session->subscription){
                        $subscription = Subscriptions::where('stripe_sid', '=', $session->subscription)->first();
                        if(!$subscription){
                 	   return;
                	}
			$subscription->pay_amount = $session->amount_due/100;
                        $grabSub = $stripe->subscriptions->retrieve($session->subscription);
                        $subscription->endDate = date('Y-m-d H:i:s', $grabSub["current_period_end"]);
                        $plan = Plans::where('subscription', '=', $subscription->id)->first();
                        $plan->endDate = date('Y-m-d H:i:s', $grabSub["current_period_end"]);
                        $invoice = Invoices::where('stripe_tid', '=',$session->id)->first();
                        
                        $invoice->paid = 1;
                        $subscription->save();
                        $invoice->save();
                    }
                }
                break;
            
            case 'invoice.payment_failed':
                $session = $event->data->object;
                if ($session->attempted == true){
                    $subscription = Subscriptions::where('stripe_sid', '=', $session->subscription)->first();
		    if(!$subscription){
                       return;
                    }
                    $plan = Plans::where('subscription', '=', $subscription->id)->first();
                    $plan->enabled = 0;
                    $plan->save();
                } else {
                    // send warning email
                }
                break;

            case 'customer.subscription.deleted':
                // Occurs whenever a customer's subscription ends.
                // $subscription = $event->data->object;

                // $customer_id = $subscription->customer;
                // $subscription_url = $subscription->items->url;
                // $arsub = explode('=', $subscription_url);
                // $subscription_id = $arsub[count($arsub) - 1];

                // $webhook_subs = Subscriptions::find($subscription_id);
                // $webhook_subs->creationDate = date("Y-m-d H:i:s", $subscription->current_period_start);
                // $webhook_subs->endDate = date("Y-m-d H:i:s", $subscription->current_period_end);
                // $webhook_subs->status = $subscription->status;
                // $webhook_subs->save(); 
                break;

            case 'customer.subscription.updated':
                // Occurs whenever a subscription changes (e.g., switching from one plan to another, or changing the status from trial to active).
                // $subscription = $event->data->object;
                // $customer_id = $subscription->customer;
                // $subscription_url = $subscription->items->url;
                // $arsub = explode('=', $subscription_url);
                // $subscription_id = $arsub[count($arsub) - 1];

                // $webhook_subs = Subscriptions::find($subscription_id);
                // $webhook_subs->creationDate = date("Y-m-d H:i:s", $subscription->current_period_start);
                // $webhook_subs->endDate = date("Y-m-d H:i:s", $subscription->current_period_end);
                // $webhook_subs->status = $subscription->status;
                // $webhook_subs->save();  

                break;

            case 'subscription_schedule.canceled':
                // $subscription = $event->data->object;

                // $customer_id = $subscription->customer;
                // $subscription_url = $subscription->items->url;
                // $arsub = explode('=', $subscription_url);
                // $subscription_id = $arsub[count($arsub) - 1];

                // $webhook_subs = Subscriptions::find($subscription_id);
                // $webhook_subs->creationDate = date("Y-m-d H:i:s", $subscription->current_period_start);
                // $webhook_subs->endDate = date("Y-m-d H:i:s", $subscription->current_period_end);
                // $webhook_subs->status = $subscription->status;
                // $webhook_subs->save(); 

                break;

            case 'customer.subscription.trial_will_end':
                // $invoice = $event->data->object;

                // if( $invoice->billing_reason == 'subscription_cycle' )
                // {
                //     // update in database for recurring payment success
                //     $customer = $invoice->customer;
                //     $customer_email = $invoice->customer_email;
                //     $subscription = $invoice->subscription;
                //     $period_start = date('Y-m-d', $invoice->period_start);
                //     $period_end = date('Y-m-d', $invoice->period_end);

                //     $plan = $invoice->lines->data[0]->plan->id;
                //     $product = $invoice->lines->data[0]->plan->product;

                //     if( $invoice->lines->data[0]->plan->interval == 'day' )
                //         $duration = 'day';
                //     else if( $invoice->lines->data[0]->plan->interval == 'month' )
                //         $duration = 'month';
                //     else if( $invoice->lines->data[0]->plan->interval == 'year' )
                //         $duration = 'year';


                //     $webhook_subs = Subscriptions::find($subscription_id);
                //     $webhook_subs->creationDate = date("Y-m-d H:i:s", $subscription->current_period_start);
                //     $webhook_subs->endDate = date("Y-m-d H:i:s", $subscription->current_period_end);
                //     $webhook_subs->status = $subscription->status;
                //     $webhook_subs->save();
                // }
                break;
        }
        http_response_code(200);
    }
    //C
    /*
    public function create(){}
    //R
    public function getAll(){
        $query = "SELECT * FROM". $this->$table_name .;

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    //U
    public function update(){}
    //D
    public function delete(){}
    */
}
