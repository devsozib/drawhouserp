<?php

namespace App\Http\Middleware;

use Closure, Session, Sentinel, Config;

class SentinelAuth {
    public function handle($request, Closure $next) {
        if (Config::get('rmconf.apps_date') < date('Y-m-d')) { abort(401); }
        if (!Sentinel::check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('login'));
            }
        }

        return $next($request);
    }

}
