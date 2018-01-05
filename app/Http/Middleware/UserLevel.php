<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Dashboard\UserController;
use GuzzleHttp\Client as GuzzleClient;
use Carbon\Carbon;
use Closure;

class UserLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user   = session('user');
        $token  = session('token');

        if(!$user)
            return;

        if($user->user_level == 0){
            session()->forget('token');
            session()->forget('user');

            return redirect()->route('dashboard.login.index', ['payment_missing' => true]);
        }
        
        if($user->remaining_days > 0)
            return $next($request);

        return $next($request);

    }
}
