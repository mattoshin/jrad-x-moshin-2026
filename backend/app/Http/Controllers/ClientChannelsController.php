<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;
use App\Models\Plans;
use App\Models\Products;
use App\Models\Servers;
use App\Models\ClientChannels;
use App\Models\ClientCategories;
use App\Models\Channels;
use App\Models\Business;

class ClientChannelsController extends Controller
{
    //
    public function getAll()
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return ClientChannels::getAll();
    }
    public function getById($id)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return ClientChannels::where('id', $request->id)->first();

    }
    public function getAllByChannelId()
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return ClientChannels::where('channelId', $request->channelId)->first();
    }
    public function getAllByUser($user)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return ClientChannels::where('user', $request->user)->all();
    }
    public function update(ClientChannels $client)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        $client ->update($request->all());
        return response()->json($client, 200);
    }

    public function addClientChannels(Request $request){ 
        if(!$request->plan){
            return [
                "status" => "error",
                "message" => "Missing Plan Parameters"
            ];
        }
        if(!$request->channel){
            return [
                "status" => "error",
                "message" => "Missing Channel Parameters"
            ];
        }
        if(!$request->control_channel){
            return [
                "status" => "error",
                "message" => "Missing Control Channel Parameters"
            ];
        }
        $row = Plans::where("id", "=", $request->plan)->first();
        $controlChannel = Channels::where('channel_id', "=", $request->control_channel)->first();
	$clientCat = ClientCategories::where('categoryid', "=", $request->category)->first();
        if($row !== null){
            ClientChannels::updateOrCreate([
                'plan' => $row->id,
                'category' => $clientCat->id,
                'controlCategory' => $controlChannel->category,
                'controlChannel' => $controlChannel->id,
                'channelId' => $request->channel,
                'enabled'=>1
            ]);
            return [
                "status" => "success",
                "message" => "Created Channel"
            ];
        }
        
        return [
            "status" => "error",
            "message" => "Invalid Monitor"
        ];
    }

    public function delete(ClientChannels $client)
    {
        $client -> delete();
        return response()-> json(null, 204);
    }
    
}
