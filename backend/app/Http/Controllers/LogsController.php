<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Logs;

class LogsController extends Controller
{
    //
    public function getAll(Request $request)
    {
        $data = Logs::all();
        return view('logs',['logs'=>$data]); 
    }
    public function getAllByType(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return Orders::where('type', $request->type)->all();
    }

    public function getById(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        $log=Logs::where('id', $request->id)->first();
        return view('log',['logs'=>$log]);
    }

    public function getAllByServerId(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return Orders::where('serverId', $request->serverId)->first();
    }
}
