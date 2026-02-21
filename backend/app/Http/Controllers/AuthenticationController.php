<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticationController extends Controller

{
    public function __construct()
    {
        $this->middleware(['auth']);
    }


    public function index()
    {
        $user = User::find($userId);

        if($user) {
            return response()->json($user);
        }
        return $request->user(); // will return the authenticated user object (from your DB), or 403.
    }
}
