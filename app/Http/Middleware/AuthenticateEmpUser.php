<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateEmpUser extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!auth()->guard('empuser')->check()) {
            return redirect('/empuser/login'); // Replace with your employee user login route
        }

        return $next($request);
    }
}
