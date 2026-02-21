<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{


    function registerView()
    {
        return view("auth-register-2");
    }
    /**
     * Show the application loginprocess.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            $user = auth()->user();

            \Session::put('success','You are Login successfully!!');
            return redirect()->route('index.html');

        } else {
            return back()->with('error','your username and password are wrong.');
        }

    }


    function doLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',   // required and email format validation
            'password' => 'required', // required and number field validation

        ]); // create the validations
        if ($validator->fails())   //check all validations are fine, if not then redirect and show error messages
        {
            return response()->json($validator->errors(),422);
            // validation failed return with 422 status

        } else {
            //validations are passed try login using laravel auth attemp
            if (\Auth::attempt($request->only(["email", "password"]))) {
                return response()->json(["status"=>true,"redirect_location"=>url("/")]);

            } else {
                return response()->json([["Invalid credentials"]],422);

            }
        }
    }
    function logout()
    {
        \Auth::logout();
        return redirect("login")->with('success', 'Logout successfully');;
    }
}
