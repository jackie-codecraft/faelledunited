<?php

namespace App\Providers;

use App\Models\SiteSettings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (str_starts_with(request()->getPathInfo(), '/en')) {
            App::setLocale('en');
        } else {
            App::setLocale('da');
        }

        // Share site settings with all front-end views
        View::composer('*', function ($view) {
            if (! str_starts_with(request()->getPathInfo(), '/admin')) {
                try {
                    $view->with('siteSettings', SiteSettings::current());
                } catch (\Exception) {
                    // DB not yet available (e.g. during migration)
                }
            }
        });
    }
}
