<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http;
use App\Models\Channels;
use App\Models\ControlCategories;

class ChannelsController extends Controller
{
    //
    private $table_name="channels";

    // table columns
    public $id;
    public $product;
    public $Channels_id;
    public $name;
   


    public function index()
    {
        return Channels::all();
    }

    public function show(Channels $Channels)
    {
        return $Channels;
    }

    public function getId($channel_id)
    {
        return Channels::findOrFail($channel_id);
    }
    public function getByEnable()
    {
        return Channels::where('enabled', '1')->all();
    }

    public function store(Request $request)
    {
        $channel = Channels::create($request->all());

        return response()->json($Channels, 201);
    }

    public function update(Request $request, Channels $Channels)
    {
        $Channels->update($request->all());
        return response()->json($Channels, 200);

    }

    public function delete(Channels $Channels)
    {
        $Channels -> delete();
        return response()-> json(null, 204);
    }

    public function getChannel(Request $request){
        $channel = Channels::where('channel_id', '=', $request->channel)->first();
        // dd($controlcat);
        if ($channel !== null){
            $channels = $channel->channels->where("enabled", "=", 1);
            $channelsids = $channels->pluck("channelId");
            $results = collect($channels)
            ->map(function ($row)  { 
                return [
                    "channelId"=>$row->channelId,
                    "name"=>$row->getPlan->name,
                    "color"=>$row->getPlan->color,
                    "picture"=>$row->getPlan->picture,
                    "role"=>$row->getPlan->role
                    
                ];
            });
            $webhooks = $channel->webhooks->where("enabled", "=", 1);
            $results2 = collect($webhooks)
            ->map(function ($row)  { 
                return [
                    "id"=>$row->id,
                    "webhook_url"=>$row->webhook_url,
                    "name"=>$row->getPlan->name,
                    "color"=>$row->getPlan->color,
                    "picture"=>$row->getPlan->picture,
                    "role"=>$row->getPlan->role
                    
                ];
            });
            return [
                "id" => $channel->channel_id,
                "name" => $channel->name,
                "enabled_channels"=>$channelsids,
                "channel_type"=>$channel->getProduct->channel_type,
                "channel_data"=>$results,
                "webhooks" => $results2->values()
            ];
        }
        return [
            "status" => "error",
            "message" => "Channel Not Found"
        ];
    }
    public function getChannels(Request $request){
        $controlcat = ControlCategories::where('categoryId', '=', $request->category)->first();
        // dd($controlcat);
        if ($controlcat !== null){
            $results = $controlcat->channels->where("enabled", "=", 1);
            $channels = $results->pluck("channelId");
            return $channels;
        }
        return [
            "status" => "error",
            "message" => "Category Not Found"
        ];
    }
    public function addChannel(Request $request){
        $controlcat = ControlCategories::where('categoryId', '=', $request->category)->first();
        $channel = Channels::create([
            'channel_id'=>$request->channel,
            "category"=>$controlcat->id,
            "product"=>$controlcat->product,
            "name"=>$request->name
        ]);
        return [
            "status" => "error",
            "message" => "Channel Added"
        ];
    }
    public function updateChannel(Request $request){
        $channel = Channels::where('channel_id', '=', $request->channel)->first();
        $channel->name = $request->name;
        $channel->save();
        return [
            "status" => "error",
            "message" => "Channel Updated"
        ];
    }
    public function deleteChannel(Request $request){
        $channel = Channels::where('channel_id', '=', $request->channel)->first();
        $channel->delete();
        return [
            "status" => "error",
            "message" => "Channel Deleted"
        ];
    }
}
