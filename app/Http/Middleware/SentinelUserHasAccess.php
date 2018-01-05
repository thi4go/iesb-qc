<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Permission;

class SentinelUserHasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!Sentinel::check()):
            return response()->view('back.errors.403', [], 403);
        endif;

        if (!Permission::has($permission)):
            return response()->view('back.errors.403', [], 403);
        endif;
        return $next($request);
    }
}
