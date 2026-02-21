<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Webhooks;
use App\Models\Plans;
use Illuminate\Support\Arr;

class WebhooksController extends Controller
{
    //


    // table name
    private $table_name="webhooks";

    // table columns
    public $id;
    public $plan;
    public $channel_id;
    public $webhooks_url;
    public $enabled;
   


    public function index()
    {
        return Webhooks::all();
    }

    public function show(Webhooks $Webhooks)
    {
        return $Webhooks;
    }

    public function getId($id)
    {
        return Webhooks::find($id);
    }
    public function getByEnable()
    {
        return Webhooks::where('enabled', '1')->all();
    }
    public function getByChannel($channel_id){
        return Webhooks::where('channel_id', '=', $channel_id)->get();
    }

    public function store(Request $request, Webhooks $webhook)
    {
        $validated = $request->only(['channel_id', 'plan', 'webhook_url', 'enabled']);
        $check = Webhooks::where('channel_id', $request->channel_id)->where('plan', $request->plan)->count();
        if($check>0){
            return Webhooks::where('channel_id', $request->channel_id)
            ->where('plan', $request->plan)
            ->update($validated);
        } else {
            return Webhooks::where('channel_id', $request->channel_id)
            ->where('plan', $request->plan)
            ->updateOrCreate($validated);
        }

        
        // Webhooks::where('channel_id', $request->channel_id)
        // ->where('plan', $request->plan)
        // ->updateOrCreate($request->all());
           
    }
    public function storesWebhooks(Request $request, Webhooks $webhook)
    {dd($request);
        $data=$request->all();
        foreach($data->webhooks as $webhook){
            $check = Webhooks::where('channel_id', $webhook->channel_id)->where('plan', $webhook->plan)->count();;
            if($check>0){
                return Webhooks::where('channel_id', $webhook->channel_id)
                ->where('plan', $webhook->plan)
                ->update($webhook->all());
            } else {
                return Webhooks::where('channel_id', $webhook->channel_id)
                ->where('plan', $webhook->plan)
                ->updateOrCreate($webhook->all());
            }
        }
    }

    
    public function storeWebhooks(Request $request, Webhooks $webhook)
    {
        // dd($request);
        $data=$request->json()->all();
        $plan=$data["plan"];
        foreach($data["changes"] as $change){
            $check = Webhooks::where('channel_id', $change["id"])->where('plan', $plan)->count();;
            if($check>0){
                Webhooks::where('channel_id', $change["id"])
                ->where('plan', $plan)
                ->update(["webhook_url" => $change["weebHookUrl"]]);
            } else {
                Webhooks::where('channel_id', $change["id"])
                ->where('plan', $plan)
                ->updateOrCreate(["plan" => $plan, "channel_id" => $change["id"], "webhook_url" => $change["weebHookUrl"]]);
            }
        }
    }

    public function updateMonitorWebhooks(Request $request)
    {
	$data=$request->json()->all();
        foreach($data["changes"] as $change){
            $plan=$change["plan"];
            $check = Webhooks::where('channel_id', $change["channel_id"])->where('plan', $plan)->count();;
            if($check>0){
                Webhooks::where('channel_id', $change["channel_id"])
                ->where('plan', $plan)
                ->update(["webhook_url" => $change["webhook_url"], "enabled" => $change["enabled"]]);
            } else {
                Webhooks::where('channel_id', $change["channel_id"])
                ->where('plan', $plan)
                ->updateOrCreate(["plan" => $plan, "channel_id" => $change["channel_id"], "webhook_url" => $change["webhook_url"], "enabled" => $change["enabled"]]);
                
            }
	    // Validate webhook URL is a Discord webhook before posting
	    if (!str_starts_with($change["webhook_url"], 'https://discord.com/api/webhooks/') && !str_starts_with($change["webhook_url"], 'https://discordapp.com/api/webhooks/')) {
	        continue;
	    }
	    $messsage = Http::post($change["webhook_url"], [
                "content" => null,
                "embeds" => [
                  [
                    "description" => "Webhook is saved correctly. Product is live.",
                    "color" => 26282,
                    "footer" => [
                        "icon_url" => "https://demo.mocean.info/static/media/logo.ea13ac93d258993e52c2.png",
                        "text" => "Powered by https://mocean.info/"
                  ]
                ]
                ],
                "username" => "Mocean Services",
                "avatar_url" => "https://media.discordapp.net/attachments/951699541030232084/965425627832406036/ocean1.png",
                "attachments" => []
              ]);
        }
        return [
            "status"=> "success",
            "message" => "Updated Webhooks"
        ];
    }

    public function update(Request $request, Webhooks $Webhooks)
    {
        $validated = $request->only(['webhook_url', 'enabled']);
        $Webhooks->update($validated);
        return response()->json($Webhooks, 200);

    }
    
    public function getByPlan(Request $request){
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        $planuserid = Plans::where('user', $value)->first();
        if (!$planuserid) return false; 
        if ($planuserid->user != $value) return false;
        if ($request->plan != $planuserid->id) return false;
        return Webhooks::where('plan', '=', $request->plan)->get();
    }
    public function delete(Webhooks $Webhooks)
    {
        $Webhooks -> delete();
        return response()-> json(null, 204);
    }
}
