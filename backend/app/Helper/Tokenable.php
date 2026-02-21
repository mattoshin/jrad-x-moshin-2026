<?php
namespace App\Helper;

use Illuminate\Support\Str;

Trait TokenableInterface{
    public function gnerateAndSaveApiAuthToken()
    {
        $token =Str::random(60);

        $this->api_token =$token;
        $this->save();
        return $this;
    }
}