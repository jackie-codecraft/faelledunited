<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next): mixed
    {
        // Admin panel is English-only
        app()->setLocale('en');

        return $next($request);
    }
}
