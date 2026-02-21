<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class validatesController extends Controller
{
    //
    public function index($user){



            return view('manageMonitors')->with($user);




    }
}
