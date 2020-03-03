<?php

namespace App\Http\Middleware;

use Closure;

class frontend
{
    public function handle($request, Closure $next)
    {
        if (setting('front_end_enable_disable') == 1) {
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}