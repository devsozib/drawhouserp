<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LogUserActivity
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
        if (Sentinel::check()) {
            $expiresAt = Carbon::now()->addMinutes(10);
            Cache::put('user-online-'.Sentinel::getUser()->id, true, $expiresAt);
        }
        return $next($request);
    }
}
