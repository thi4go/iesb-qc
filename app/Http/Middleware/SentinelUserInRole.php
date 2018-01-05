<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelUserInRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Sentinel::check()):
            return response()->view('back.errors.403', [], 403);
        endif;

        if (!Sentinel::inRole($role)):
            return response()->view('back.errors.403', [], 403);
        endif;

        return $next($request);
    }
}
