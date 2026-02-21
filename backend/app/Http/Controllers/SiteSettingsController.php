<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    //

        public function getAll(Request $request)
        {  
            $cookie = $request->cookie('user');
            if (!$cookie) return false;
            $value = json_decode($cookie, true)["user"]["id"];
            return SiteSettings::getAll();
        }

        public function getByVariable(Request $request)
        {
            $cookie = $request->cookie('user');
            if (!$cookie) return false;
            $value = json_decode($cookie, true)["user"]["id"];
            $data = SiteSettings::where('variable', $request->variable)->first();
            return $data;

        }

        public function update (SiteSettings $site)
        {
            $cookie = $request->cookie('user');
            if (!$cookie) return false;
            $value = json_decode($cookie, true)["user"]["id"];
            $site ->update($request->all());
            return response()->json($site, 200);
        }

}
