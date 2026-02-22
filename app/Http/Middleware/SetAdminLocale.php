<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next): mixed
    {
        $locale = 'en'; // default for unauthenticated (login page, etc.)

        if ($user = $request->user()) {
            $locale = in_array($user->locale, ['da', 'en']) ? $user->locale : 'en';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
