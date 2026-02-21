<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;
use App\Models\Plans;
use Illuminate\Support\Facades\Http;
use App\Models\Products;
use App\Models\Servers;
use App\Models\Business;
use App\Models\ClientChannels;
use App\Models\ControlCategories;

class ControlCategoriesController extends Controller
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
    public function getByProduct()
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return ClientChannels::where('product', $request->product)->first();
    }
    public function update(ControlCategories $control)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        $control ->update($request->all());
        return response()->json($control, 200);
    }

    public function delete(ControlCategories $control)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        $control -> delete();
        return response()-> json(null, 204);
    }

    public function grabAllChannels(ClientChannels $client)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return $client::getAll();
    }
    public function adminUpdate(Request $request){
        $product = Products::where('id', $request->product)->first();
        $category = ControlCategories::where('product', '=', $product->id)->first();
        $category->categoryId = $request->category;
        $category->save();
        session()->put('success','Record updated successfully.');
        return redirect('admin/product/edit/'.$product->id);
    }
    public function adminCreate(Request $request){
        $product = Products::where('id', $request->product)->first();
        $category = ControlCategories::create([
            'product'=>$product->id,
            "categoryId"=>$request->category,
            "type"=>$product->channel_type,
        ]);
        $info_request = "http://127.0.0.1:5000/get_monitor";
        $data = [
            'monitor' => $request->category
        ];
        $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
        session()->put('success','Record created successfully.');
        return redirect('admin/product/edit/'.$product->id);
    }

    public function getCategory(Request $request){
        $controlcat = ControlCategories::where('categoryId', '=', $request->category)->first();
        // dd($controlcat);
        if ($controlcat !== null){
            return [
                "id" => $controlcat->categoryId,
                "name" => $controlcat->name,
                "enabled" => $controlcat->enabled,
                "type" => $controlcat->type,
                "synced_categories"=> $controlcat->clientcategories
            ];
        }
        return [
            "status" => "error",
            "message" => "Category Not Found"
        ];
    }
    public function getCategoryChannels(Request $request){
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

}
