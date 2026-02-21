<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Permissions;

class PermissionsController extends Controller
{
    public function getAll(Request $request)
    {  
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        return Permissions::getAll();
    }

    public function getByBusiness(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        $data = Permissions::where('business', $request->input('business'))->all();
        return $data;

    }
    public function getByUser(Request $request)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        $data = Permissions::where('business', $value)->all();
        return $data;

    }
    public function isAdmin(Request $request)
    {

    }
    
    public function store(Request $request)
    {
        $permission = Permission::create($request->all());

        return response()->json($permission, 201);
    }
    public function matchQuery(Request $request)
    {
        $cookie = $request->cookie('user');
        $value = json_decode($cookie, true)["user"]["id"];
        $business = Business::where('owner', $value);
        if ($request->input('business') === $business) return true; 
    }
    public function getAllByUserBusiness(Request $request)
    {
        $cookie = $request->cookie('user');
        $value = json_decode($cookie, true)["user"]["id"];
        $business = Business::where('owner', $value);
        if ($request->input('business') === $business);
        $data = Permission::where('business', $business)->where('user', $value);
        return $data;

    }

    public function update (Request $request, Permission $perm)
    {
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
       if ($value !== $perm->id) return false;

        $perm ->update($request->all());
        return response()->json($perm, 200);
    }
    public function delete(Permission $permission)
    {
        $cookie = $request->cookie('user');
        $value = json_decode($cookie, true)["user"]["id"];
        $business = Business::where('owner', $value);
        if ($request->input('business') === $business);
        $permission -> delete();
        return response()-> json(null, 204);
    }

}
