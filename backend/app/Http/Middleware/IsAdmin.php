<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\isAdmin as Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated via Laravel's session auth
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && $user->admin === true) {
                return $next($request);
            }
        }

        // Fallback: check cookie-based auth with timing-safe comparison
        if ($request->hasCookie('admin')) {
            $value = $request->cookie('admin');
            $users = json_decode($value, true);
            if (isset($users['token']) && isset($users['user'])) {
                $apiT = $users['token'];
                $userDetails = $users['user'];
                $user = User::where('id', $userDetails)->first();

                if ($user && hash_equals($user->api_token, $apiT)) {
                    if ($user->admin === true) {
                        return $next($request);
                    }
                }
            } else {
                \Cookie::expire('admin');
            }
        }

        return redirect('/');
    }
    
}
