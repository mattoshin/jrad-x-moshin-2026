<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;
use App\Models\Plans;
use App\Models\Products;
use App\Models\Servers;
use App\Models\Business;
use App\Models\ClientChannels;
use App\Models\ControlCategories;
use App\Models\ClientCategories;

class ClientCategoriesController extends Controller
{
   
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

    public function createCategory(Request $request){
        $category = ClientCategories::create([
            "categoryid"=>$request->categoryid,
            "plan"=>$request->plan,
            "category"=>$request->control_category,
            "enabled"=>1,
        ]);
        if($category){
            return [
                "status"=>"success",
                "message"=>"Created category"
            ];
        }
        return [
            "status"=>"error",
            "message"=>"Failed to create category"
        ];
    }

    public function getCategory(Request $request){
        $controlcat = ClientCategories::where('categoryid', '=', $request->category)->first();
        // dd($controlcat);
        if ($controlcat !== null){
            return [
                "id" => $controlcat->categoryid,
                "name" => $controlcat->name,
                "enabled" => $controlcat->enabled
            ];
        }
        return [
            "status" => "error",
            "message" => "Category Not Found"
        ];
    }
    public function getByCategory(Request $request){
        $controlcat = ControlCategories::where('categoryId', '=', $request->category)->first();
        // dd($controlcat);
        if ($controlcat !== null){
            $results = $controlcat->clientcategories->where("enabled", "=", 1);
            $categories = $results->pluck("categoryid");
            return $categories;
        }
        return [
            "status" => "error",
            "message" => "Category Not Found"
        ];
    }

}
