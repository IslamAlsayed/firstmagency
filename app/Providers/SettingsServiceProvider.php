<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\SettingsHelper;
use Illuminate\Support\Facades\Config;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Preload settings to cache
        $settings = SettingsHelper::get();

        if ($settings && isset($settings->ably_key) && $settings->ably_key !== null) {
            Config::set('app.ably_key', $settings->ably_key ?: config('app.ably_key'));
        }

        view()->share('appSettings', $settings);
        view()->share('settings', $settings);
    }
}
