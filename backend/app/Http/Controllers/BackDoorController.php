<?php

namespace App\Http\Controllers;

use Validator;
use Session;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Categories;

class BackDoorController extends Controller
{
   public function __construct()
{
    $this->middleware('guest:admin')->except(['logout']);
   // $this->middleware('auth');
}

    public function getAdmin(Request $request)
    {   
        
        return redirect('/admin/home');
    }

    public function redirectTo(Request $request) {
        $value= $request->cookie('user');
        $isAdmin= $value->admin;
        switch ($isAdmin) {
          case 0:
            return '/home';
            break;
          case 1:
            return '/admin/products';
            break; 
      
          default:
            return '/home'; 
          break;
        }
      }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            $user = auth()->guard('admin')->user();
            
            \Session::put('success','You are Login successfully!!');
            return redirect()->route('dashboard');
            
        } else {
            return back()->with('error','your username and password are wrong.');
        }

    }
    
  
    
    public function dashboard()
    {
      
            return view('products');
        
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        \Session::flush();
        \Sessioin::put('success','You are logout successfully');
        return redirect(route('/admin'));
    }

    public function signUp(Request $request):Admin
    {   
        $admin=new Admin;
        $admin->email=$request->email;
        $admin->password=Hash::make($request->password);
        $admin->save();
        return('success');
        
    }
    public function adminSign(){
        return view('auth-register-2');
    }

    public function addProduct(){
        $categories = Categories::all();
        return view('add_product')->with('categories', $categories);
    }


}
