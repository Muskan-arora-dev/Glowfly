<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->is_admin != 1) {
            return redirect('/login')->with('error', 'Access denied');
        }

        return $next($request);
    }
}
