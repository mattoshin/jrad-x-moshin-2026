<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Business;
use App\Models\Servers;
use App\Models\User;
use App\Models\Plans;
use App\Models\Subscriptions;
use App\Models\Permissions;
use App\Models\Products;
use App\Models\Invoices;
use Illuminate\Support\Facades\Http;

class ServersController extends Controller
{
    //

    // table name
    private $table_name="servers";

    // table columns
        public $id;
        public $owner;
        public $business;
        public $guild_id;
        public $server_avatar;
        public $creation_date;
        public $join_dat;



    public function index()
    {
        return Servers::all();
    }

    public function show(Server $server)
    {
        return $server;
    }
    public function getId($id){
        return Servers::find($id);
    }
    public function getBusiness($business)
    {
        return Servers::where('business',$business)->first();
    }
    public function getOwner($owner)
    {
        return Servers::where('owner', $owner)->first();
    }
    public function getGuildId($guild_id)
    {
        return Servers::where('guild_id', $guild_id)->first();
    }

    public function store(Request $request)
    {
        $server = Server::create($request->all());

        return response()->json($server, 201);
    }

    public function update(Request $request, Server $server)
    {
        $server->update($request->all());
        return response()->json($server, 200);

    }
    public function delete(Server $server)
    {
        $server -> delete();
        return response()-> json(null, 204);
    }

    public function getMonitor(Request $request){
        
        $row = Plans::where("id", "=", $request->monitor)->first();
        if($row !== null){
            $d = new \DateTime();
            $d->setTimestamp($row->endDate);
            $daysleft = $d->diff(new \DateTime())->format('%a')+1;
            return [
                "id"=>$row->id,
                "product" => [
                    "id"=>$row->getProduct->id,
                    "name"=>$row->getProduct->name,
                    "channel_type"=>($row->getProduct->channel_type == 1 ? "Curated Category" : "Webhooks"),
                ],
                "control_category" => [
                    "id"=>$row->getProduct->controlCategory->id,
                    "name"=>$row->getProduct->controlCategory->name,
                    "category"=>$row->getProduct->controlCategory->categoryId,
                ],
                "server"=>$row->getBusiness->server->guild_id,
                "channels"=>$row->channels,
                "webhooks"=>$row->webhooks,
                "fulfilled"=>($row->fulfilled ? "true" : "false"),
                "days_left"=>$daysleft,
            ];
        }

        return [
            "status" => "error",
            "message" => "Invalid Monitor"
        ];
    }
    public function getServers()
    {
        $servers = Servers::all();
        $serverids = $servers->pluck("guild_id");
        return $serverids;
    }
    public function getServersByPlan(Request $request)
    {
        $plans = Plans::where("product", "=", $request->product)->get();
        $servers = collect($plans)
            ->map(function ($row) {
                $server = Servers::where('business', '=', $row->business)->first();

                return $server->guild_id;
            });
        $serverids = $servers->pluck("guild_id");
        return $servers;
    }
}
