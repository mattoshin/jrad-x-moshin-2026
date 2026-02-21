<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http;
use App\Models\Business;
use App\Models\Servers;
use App\Models\User;
use App\Models\Plans;
use App\Models\Subscriptions;
use App\Models\Permissions;
use App\Models\Announcements;
use App\Models\Products;
use App\Models\Invoices;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
     //

     // table name
     private $table_name="businesses";

     // table columns
     public $id;
     public $owner;
     public $name;
     public $email;
     public $twitter;




     public function index()
     {
         $businesses = Business::all();
         return view('businesses', ['businesses'=>$businesses]);
     }

     public function show(Business $business)
     {
         return $business;
     }
     public function getId($id)
     {
        $businesses = Business::find($id);
        return view('business', ['business'=>$businesses]);
     }
     public function getOwner($owner)
     {
         return Business::where('owner', $owner)->first();
     }

     public function gnerateAndSaveApiAuthToken()
   {
       
       $token =Str::random(60);
       return $token;
   }

     public function store(Request $request, Business $business)
     {
      $validated = $request->only(['name', 'email', 'twitter', 'description', 'location', 'currency', 'website', 'phone']);
      return  Business::where('owner',$request->owner)->update($validated);
        /*
         $businesses =new Business;
         $businesses->owner=$request->owner;
         $businesses->name=$request->name;
         $businesses->email=$request->email;
         $businesses->twitter=$request->twitter;
         $businesses->save();*/

           
         ;
     }
     public function addAdmins(Request $request, Business $business, Servers $server)
     {
         
         $users = $request->users;
         
             Permissions::updateOrCreate([
                 'user' => $users->id,
                'business' => $users->business,
                'dicordId' => $users->dicordId,
                'permission' =>  8,
                "permission_token" => Str::random(60),
                'last_update' => now()
             ]);
     }
     public function deletePermission(Request $request, Servers $servers, Business $business)
     {
        $users = $request->users;
        foreach ($users as $key => $value) {
            $deleted = Servers::where('owner', $vlaue->owner)->delete();
        }
        return $deleted;
     }
     

     public function update(Request $request, Business $business)
     {
         $validated = $request->only(['name', 'email', 'twitter', 'description', 'location', 'currency', 'website', 'phone']);
         $business->update($validated);
         return response()->json($business, 200);

     }

     public function delete(Business $business)
     {
         $business -> delete();
         return response()-> json(null, 204);
     }
     
     public function getProducts(Request $request){
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        //["stock", ">=", 0]
        $matchThese = [["visible", "=", 1]];
        $products = Products::where($matchThese)->get();
        $matchThese2 = [["business", "=", $business->id], ["enabled", "!=", 0]];
        $collection = Plans::where($matchThese2)->get();
        $productids =  $collection->pluck('product');
        $filtered = $products->filter(function($product) use ($productids) {
            if(!$productids->contains($product["id"])){ 
                return $product;
            }
        });

        $results = collect($filtered)
        ->map(function ($row) {
            return [
                "id"=>$row->id,
                "category"=>$row->category->name,
                "channel_type"=>($row->channel_type == 1 ? "Curated Category" : "Webhooks"),
                "name"=>$row->name,
                "description"=>$row->description,
                "price"=>$row->price,
                "trial"=>$row->trial,
                "trial_period"=>$row->trial_period
            ];
        });
        if(!$this->isJson($results)){   
            return $results;
        } else {        
            return $results->values();
        }
     }
     public function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
     }
     
     public function getActiveProducts(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
	$plans = Plans::where([
            ["business", "=", $business->id],
            ["enabled", "=", 1],
        ])->get();
        $results = collect($plans)
        ->map(function ($row) {
            $d = new \DateTime();
            $d->setTimestamp($row->endDate);
            $daysleft = $d->diff(new \DateTime())->format('%a')+1;
            return [
                "id"=>$row->getProduct->id,
                "plan"=>$row->id,
                "category"=>$row->getProduct->category->name,
                "name"=>$row->getProduct->name,
                "description"=>$row->getProduct->description,
                "channel_type"=>($row->getProduct->channel_type == 1 ? "Curated Category" : "Webhooks"),
                "price"=>$row->getProduct->price,
                "trial"=>$row->activeTrial,
                "days_left"=>$daysleft,
                "cancel"=>$row->cancel
            ];
        });
        return $results;
     }

     public function getInvoices(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        $plans = Invoices::where("business", "=", $business->id)->get();
        $subscriptions = Subscriptions::where("business", "=", $business->id)->get();
        $currentMonth = date('m');
        $month = Invoices::where("business", "=", $business->id)->whereRaw('MONTH(creationDate) = ?',[$currentMonth])->get();
        $months = Invoices::selectRaw('year(creationDate) as year, monthname(creationDate) as month, sum(pay_amount) as total_amount')
            ->whereYear('creationDate', date('Y'))
            ->where("business", "=", $business->id)
            ->groupBy('year','month')
            ->orderByRaw('min(creationDate) desc')
            ->get();
        $results = collect($plans)
        ->map(function ($row) {
            return [
                "id"=>$row->id,
                "business"=>[
                    "id"=>$row->getBusiness->id,
                    "name"=>$row->getBusiness->name,
                ],
                "product"=>[
                    "id"=>$row->getProduct->id,
                    "name"=>$row->getProduct->name,
                ],
                "subscription" => $row->sub,
                "stripe_transaction" => $row->stripeTId,
                "plan"=>$row->plan,
                "paid"=>$row->paid,
                "billing_name" => $row->billing_name,
                "billing_address" => $row->billing_address,
                "billing_email" => $row->billing_email,
                "payment_method" => $row->pay_method,
                "payment_amount" => $row->pay_amount,
                "creation_date" => $row->creationDate
            ];
        });
        return [
            "totalPaid" => $plans->where('paid', "=", 1)->sum('pay_amount'),
            "totalUnpaid" => $plans->where('paid', "=", 0)->sum('pay_amount'),
            "monthlyTotal" => $subscriptions->sum('pay_amount'),
            "monthTotalPaid" => $month->where('paid', "=", 1)->sum('pay_amount'),
            "monthTotalUnpaid" => $month->where('paid', "=", 0)->sum('pay_amount'),
            "chart_data"=>$months,
            "invoices" => $results
        ];
    }
    

    public function getInvoice(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        $matchThese = [["business", "=", $business->id], ["id", "=", $request->invoice]];
        $plans = Invoices::where($matchThese)->get();
        $results = collect($plans)
        ->map(function ($row) {
            return [
                "id"=>$row->id,
                "business"=>[
                    "id"=>$row->getBusiness->id,
                    "name"=>$row->getBusiness->name,
                ],
                "product"=>[
                    "id"=>$row->getProduct->id,
                    "name"=>$row->getProduct->name,
                ],
                "subscription" => $row->sub,
                "stripe_transaction" => $row->stripeTId,
                "plan"=>$row->plan,
                "paid"=>$row->paid,
                "billing_name" => $row->billing_name,
                "billing_address" => $row->billing_address,
                "billing_email" => $row->billing_email,
                "payment_method" => $row->pay_method,
                "payment_amount" => $row->pay_amount,
                "creation_date" => $row->creationDate
            ];
        });
        return $results;
    }
    public function getMonitors(Request $request){
       
       if(!$request->bearerToken()){
           return [
               "status" => "error",
               "message" => "Invalid Authorization"
           ];
       }
       $business = Business::where('api_token', $request->bearerToken()) -> first();
       if(!$business){
           return [
               "status" => "error",
               "message" => "Invalid Key"
           ];
       }
       $plans = Plans::where("business", "=", $business->id)->get();
       $results = collect($plans)
        ->map(function ($row) {
            $d = new \DateTime();
            $d->setTimestamp($row->endDate);
            $daysleft = $d->diff(new \DateTime())->format('%a')+1;
            return [
                "id"=>$row->id,
                "category"=>$row->getProduct->category->name,
                "name"=>$row->getProduct->name,
                "description"=>$row->getProduct->description,
                "price"=>$row->getProduct->price,
                "trial"=>$row->activeTrial,
                "days_left"=>$daysleft,
                "cancel"=>$row->cancel
            ];
        });
        return $results;
    }
    public function getMonitor(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        $matchThese = [["business", "=", $business->id], ["product", "=", $request->monitor]];
        $row = Plans::where($matchThese)->first();
	if($row !== null){
            $d = new \DateTime();
            $d->setTimestamp($row->endDate);
            $daysleft = $d->diff(new \DateTime())->format('%a')+1;
            $channels = $row->getAccessChannels();
            $results = collect($channels)
            ->map(function ($channel) use ($row, $channels) {
                $webhook = $channel->webhook($row->id);
                return [
                    "channel_id" => $channel->id,
                    "plan" => $row->id,
                    "name" => $channel->name,
                    "webhook_id" => $webhook->id ?? null,
                    "webhook_url" => $webhook->webhook_url ?? null,
                    "enabled" => $webhook->enabled ?? 0
                ];
            });
            return [
                "id"=>$row->id,
                "name"=>$row->getProduct->name,
                "channel_type"=>($row->getProduct->channel_type == 1 ? "Curated" : "Webhooks"),
                "control_channels"=>$row->getAccessChannels(),
                "channels"=>$row->channels,
                "webhooks"=>$row->webhooks,
                "combined"=>$results,
                "days_left"=>$daysleft,
            ];
        }
        return [
            "status" => "error",
            "message" => "Invalid Monitor"
        ];
    }

    
    public function getMonitorWebhooks(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        $matchThese = [["business", "=", $business->id], ["id", "=", $request->monitor]];
        $row = Plans::where($matchThese)->first();
        if($row !== null){
            $d = new \DateTime();
            $d->setTimestamp($row->endDate);
            $daysleft = $d->diff(new \DateTime())->format('%a')+1;
            return [
                "id"=>$row->id,
                "webhooks"=>$row->webhooks,
            ];
        }

        return [
            "status" => "error",
            "message" => "Invalid Monitor"
        ];
    }
    public function getBusinessMe(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        
        return [
            "id"=>$business->id,
            "owner"=>[
                "discord" =>strval($business->getOwner->discord_id),
                "username" =>$business->getOwner->username
            ],
            "name"=>$business->name,
            "email"=>$business->email,
            "twitter"=>$business->twitter,
            "description"=>$business->description,
            "currency"=>$business->currency,
            "location"=>$business->location,
            "website"=>$business->website,
            "phone"=>$business->phone
        ];
    }
    
    

    public function getPlan(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        $matchThese = [["business", "=", $business->id], ["product", "=", $request->plan]];
        $row = Plans::where($matchThese)->first();
        if($row !== null){
            $d = new \DateTime();
            $d->setTimestamp($row->endDate);
            $daysleft = $d->diff(new \DateTime())->format('%a')+1;
            return [
                "id"=>$row->id,
                "name"=>$row->name,
                "color"=>$row->color,
                "picture"=>$row->picture,
                "role"=>$row->role,
                "plan_name"=>$row->getProduct->name,
                "days_left"=>$daysleft,
                "cancel"=>$row->cancel
            ];
        }

        return [
            "status" => "error",
            "message" => "Invalid Monitor"
        ];
    }

    public function updatePlan(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        $matchThese = [["business", "=", $business->id], ["product", "=", $request->plan]];
        $plan = Plans::where($matchThese)->first();
        if($plan !== null){
            
            if($request->name){
                $plan->name = $request->name;
            }
            if($request->color){
                $plan->color = $request->color;
            }
            if($request->picture){
                $plan->picture = $request->picture;
            }
            if($request->role){
                $plan->role = $request->role;
            }
            $plan->save();
            return [
                "status" => "success",
                "message" => "Updated Plan Details"
            ];
        }

        return [
            "status" => "error",
            "message" => "Invalid Plan"
        ];
    }

    public function updateBusinessSettings(Request $request){
        
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Invalid Authorization"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Key"
            ];
        }
        if($request->name){
            $business->name = $request->name;
        }
        if($request->email){
            $business->email = $request->email;
        }
        if($request->twitter){
            $business->twitter = $request->twitter;
        }
        if($request->description){
            $business->description = $request->description;
        }
        if($request->location){
            $business->location = $request->location;
        }
        if($request->website){
            $business->website = $request->website;
        }
        if($request->phone){
            $business->phone = $request->phone;
        }
        if($request->currency){
            $business->currency = $request->currency;
        }
        $business->save();
        return [
            "status" => "success",
            "message" => "Updated Business Details"
        ];
    }
    public function selectServer(Request $request, Servers $server, Business $business)
    {
        
    }
    public function create(Request $request, Servers $server, Business $business){
        $data = $request->all();
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Missing Business Token"
            ];
        }
        $user = User::where('api_token', $request->bearerToken()) -> first();
        if(!$user){
            return [
                "status" => "error",
                "message" => "User not found"
            ];
        }
        $server = $data['server'];
        $servers = Servers::where('guild_id', $server)->first();
        if($servers !== null ) {
            return([
                'status' =>'error',
                'token' => "Business already exists"
            ]);
        }
            
            // this api request doesn't work
            $info_request = "https://discordapp.com/api/v8/guilds/" . $server;
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Content-Length" => "0",
                "Authorization" => "Bot " . env('DISCORD_BOT_TOKEN'),
            ])->get($info_request);
            // $response->throw();    
            if($response->status() == 403) return [ "status" => "error", "message" => "Bot isn't in server"];
            if ($response->status() != 200) return [ "status" => "error", "message" => "Unknown Error"];
	    $guilds = json_decode($response->getbody(), true);
            $user = User::where('discord_id', $guilds["owner_id"])->first();
            if(!$user){
                $user = User::create([
                    'discord_id'=>$guilds["owner_id"]
                ]);
            }
            $id = $user['id'];
            $business = Business::create([
                'owner' => $id,
                'api_token' => $this->gnerateAndSaveApiAuthToken()
            ]);
            $api_token = $business->api_token;
            $businessID = $business->id;
        
            $newServer = Servers::create([
                'guild_id' => $server,
                'owner' => $id,
                'name'=>$guilds['name'],
                'business' => $businessID

            ]);

            
            return([
                'status' =>'success',
                'token' => $business['api_token']
            ]);
        
        
     }

     public static function getAdminInvoices(Business $business){
       
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Business"
            ];
        }
        $plans = Invoices::where("business", "=", $business->id)->get();
        $subscriptions = Subscriptions::where("business", "=", $business->id)->get();
        $currentMonth = date('m');
        $month = Invoices::where("business", "=", $business->id)->whereRaw('MONTH(creationDate) = ?',[$currentMonth])->get();
        $results = collect($plans)
        ->map(function ($row) {
            return [
                "id"=>$row->id,
                "business"=>[
                    "id"=>$row->getBusiness->id,
                    "name"=>$row->getBusiness->name,
                ],
                "product"=>[
                    "id"=>$row->getProduct->id,
                    "name"=>$row->getProduct->name,
                ],
                "subscription" => $row->sub,
                "stripe_transaction" => $row->stripeTId,
                "plan"=>$row->plan,
                "paid"=>$row->paid,
                "billing_name" => $row->billing_name,
                "billing_address" => $row->billing_address,
                "billing_email" => $row->billing_email,
                "payment_method" => $row->pay_method,
                "payment_amount" => $row->pay_amount,
                "creation_date" => $row->creationDate
            ];
        });
        return [
            "totalPaid" => $plans->where('paid', "=", 1)->sum('pay_amount'),
            "totalUnpaid" => $plans->where('paid', "=", 0)->sum('pay_amount'),
            "monthlyTotal" => $subscriptions->sum('pay_amount'),
            "monthTotalPaid" => $month->where('paid', "=", 1)->sum('pay_amount'),
            "monthTotalUnpaid" => $month->where('paid', "=", 0)->sum('pay_amount'),
            "invoices" => $results
        ];
     }

     public static function getDiscordDetails(Business $business){
        $info_request = "http://127.0.0.1:5000/server";
        $data = [
            'guild_id' => $business->server->guild_id
        ];
        $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
        $response->throw();
        $guilds = json_decode($response->getbody(), true);
        return $guilds;
     }
     public static function getAdminOwner(Business $business){
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Business"
            ];
        }
        return [
            "id" => $business->getOwner->id,
            "username" => $business->getOwner->username,
            "email" => $business->getOwner->email,
            "discord_id" => $business->getOwner->discord_id,
            "join_date" => $business->getOwner->creationDate
        ];
     }

     public static function getAdminActiveProducts(Business $business){
        if(!$business){
            return [
                "status" => "error",
                "message" => "Invalid Business"
            ];
        }
        $plans = Plans::where("business", "=", $business->id)->get();
        $results = collect($plans)
        ->map(function ($row) {
            $d = new \DateTime();
            $d->setTimestamp($row->endDate);
            $daysleft = $d->diff(new \DateTime())->format('%a')+1;
            return [
                "id"=>$row->id,
                "category"=>$row->getProduct->category->name,
                "name"=>$row->getProduct->name,
                "description"=>$row->getProduct->description,
                "channel_type"=>($row->getProduct->channel_type == 1 ? "Curated" : "Webhooks"),
                "price"=>($row->getSubscription->pay_amount ?? 'No Subscription'),
                "start_date"=>$row->startDate,
                "days_left"=>$daysleft,
            ];
        });
        return [
            "total"=>count($plans),
            "products"=>$results
        ];
     }
public function getProductAnnouncements(Request $request){
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Missing Business Token"
            ];
        }
        $user = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$user){
            return [
                "status" => "error",
                "message" => "Business not found"
            ];
        }
        $product = Products::where('id', "=", $request->product)->first();
        if(!$product){
            return [
                "status" => "error",
                "message" => "Product not found"
            ];
        }
        $announcements = Announcements::where("product", "=", $product->id)->get();
        $results = collect($announcements)
        ->map(function ($row) {
            return [
                "id"=>$row->id,
                "product"=>$row->getProduct->name,
                "announcement"=>$row->announcement
            ];
        });
        return $announcements;

     }
public function getAllAnnouncements(Request $request){
        if(!$request->bearerToken()){
            return [
                "status" => "error",
                "message" => "Missing Business Token"
            ];
        }
        $business = Business::where('api_token', $request->bearerToken()) -> first();
        if(!$business){
            return [
                "status" => "error",
                "message" => "Business not found"
            ];
        }

        // Get products
        $plans = Plans::where("business", "=", $business->id)->get();

        $products = $plans->pluck('product');

        $announcements = Announcements::all();



	$filtered = array();
        $results = collect($announcements)
        ->map(function ($row) use ($products, $filtered) {
            if($products->contains($row["product"])){ 
		$yes=[
                    "id"=>$row->id,
                    "product"=>$row->getProduct(),
                    "announcement"=>$row->announcement
                ];
                array_push($filtered, $yes);
            }
        });

        return $filtered;
    }
}
