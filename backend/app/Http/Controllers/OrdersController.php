<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\Orders;
use App\Models\User;
use App\Models\Plans;
use App\Models\Products;
use App\Models\Servers;
use App\Models\Invoices;
use App\Models\Business;

class OrdersController extends Controller
{
    //
    public function GetAll(Request $request)
    {
        $data = Invoices::get();
        return view('orders',['orders'=>$data]); 
    }

    public function grabById(Request $request)
    {
        $data = Invoices::find($request->id);
        return view('order',['order'=>$data]); 
    }
    public function grabByUser(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return Orders::where('user', $request->user)->all();
    }

    public function grabBySub(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return Orders::where('sub', $request->sub)->all();
    }

    public function grabByPlan(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return Orders::where('plan', $request->plan)->all();
    }

    public function grabByStripSubId(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return Orders::where('stripePId', $request->stripePId)->all();
    }

    public function update(Orders $orders)
    {
        $orders ->update($request->all());
        return response()->json($orders, 200);
    }

    public function delete (Orders $orders)
    {
        $orders -> delete();
        return response()-> json(null, 204);
    }

    public function GetSubFromOrder(Request $req)
    {
        $data = Orders::get('sub')->first();
        return $data;
    }

}
