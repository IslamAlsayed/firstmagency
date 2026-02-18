<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default locale to Arabic
        app()->setLocale('ar');
        
        // Force HTTPS for Cloudflare tunnel
        if (env('APP_ENV') === 'production' || request()->server('HTTP_CF_VISITOR')) {
            URL::forceScheme('https');
        }
    }
}
