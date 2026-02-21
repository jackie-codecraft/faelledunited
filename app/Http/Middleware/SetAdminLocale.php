<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next): mixed
    {
        $locale = 'da'; // default

        if ($user = $request->user()) {
            $locale = $user->locale ?? 'da';
        }

        app()->setLocale(in_array($locale, ['da', 'en']) ? $locale : 'da');

        return $next($request);
    }
}
