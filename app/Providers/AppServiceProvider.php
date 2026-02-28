<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Providers\SettingsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(SettingsServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for Cloudflare tunnel
        if (env('APP_ENV') === 'production' || request()->server('HTTP_CF_VISITOR')) {
            URL::forceScheme('https');
        }
    }
}
