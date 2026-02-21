<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;
use App\Models\Plans;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Servers;
use App\Models\Business;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

        public $id;
        public $discord_id;
        public $username;
        public $email;
        private $password;

    function register(Request $req){
        $user = new User;
        $user->username=$req->input('username');
        $user->id=$req->input('id');
        $user->discriminator=$req->input('discriminator');
        $user->email=$req->input('email');
        $user->password=$req->input('password');

        $user->save();

        return $user;
    }
    function discoAuth(Request $req){
        return $req;
    }
    public function index()
    {   
        
        $users = User::all();
        $results = collect($users)
        ->map(function ($row) {
            return [
                "id"=>$row->id,
                "discordId"=>$row->discord_id,
                "username"=>$row->username,
                "email"=>$row->email,
                "avatar"=>$row->avatar,
                "creationDate"=>$row->creationDate
            ];
        });
        return $results;
        // $business = Business::all();
        // $server= Servers::all();
        // $user = User::all();
        // return view ('users', ['user'=>$user,'servers'=>$server]);
    }
    
    public function adminIndex()
    {   
        $business = Business::all();
        $server= Servers::all();
        $users = User::all();
        $plans = Plans::where('enabled', '=', 1)->get();

        $usersArray = $plans->pluck('user');

        $filtered = $users->filter(function($user) use ($usersArray) {
            if($usersArray->contains($user["id"])){                   
                return $user;
            }
        });

        

        return view ('users', ['user'=>$filtered,'servers'=>$server]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->only(['discord_id', 'username', 'email', 'avatar']);
        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->only(['username', 'email', 'avatar']);
        $user->update($validated);
        return view('user');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function getId($id)
    {  
        $user = User::find($id);
        return view('user', ['user'=>$user]);
        /*
            DB::table('users')
                ->chunkById(100, function ($users) {
                    foreach ($users as $user) {
                        DB::table('users')
                            ->where('id', $user->id)
                    }
                });
                */
    }

    public function getById($id)
    {   $user = User::find($id);
        return [
            "id"=>$user->id,
            "discordId"=>$user->discord_id,
            "username"=>$user->username,
            "email"=>$user->email,
            "avatar"=>$user->avatar,
            "creationDate"=>$user->creationDate
        ];
    }

    
    public function getByToken($token)
    {   $user = User::where('api_token', $token) -> first();
        return [
            "id"=>$user->id,
            "discordId"=>$user->discord_id,
            "username"=>$user->username,
            "email"=>$user->email,
            "avatar"=>$user->avatar,
            "creationDate"=>$user->creationDate
        ];
    }

    public function getUsername($username)
    {
        return User::where('username', $username) -> first();
    }
    public function getEmail($email)
    {
        return User::where('email', $email) ->first();
    }
    public function userEdit(){
        return view('user');
    }
    public function getThem($discord_id)
    {
        return User::where('discord_id', $discord_id)->first();
    }

    public function homeRedirect(Request $request){
        if($request->hascookie('user')){
            return redirect('/home');
        }
        return redirect('/login');
    }

    public function directMessage(Request $request )
    {   
        $path ='https://discordapp.com/api/user/' + $request->discord_id +'/message';
        $messsage = Http::post($path, [$request->message]);
        return true;
    }

    public function toggleAdmin(Request $request){
        // Check for userID
        if(!$request->userId){
            session()->put('error','User not found.');
            return redirect('admin/users');
        }

        //Find user
        $user = User::where('id', '=', $request->userId)->first();

        // Invalid User
        if(!$user) {
            session()->put('error','User not found.');
            return redirect('admin/users');
        }

        // Switch perms
        $user->admin = !$user->admin;

        // Save User
        $user->save();


        session()->put('success','Record updated successfully.');
        return redirect('admin/user/'.$request->userId);

    }
}
