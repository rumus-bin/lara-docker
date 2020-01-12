<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class CheckAdminRole
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()) {
            return $next($request);
        }

        auth()->logout();
        return redirect(route('login'));
    }
}
