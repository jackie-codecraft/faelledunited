<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next): mixed
    {
        app()->setLocale('en');

        return $next($request);
    }
}
