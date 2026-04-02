<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\SettingsHelper;
use App\Models\Setting;
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

        // Keep shared view variable object-shaped to avoid "property on null" errors
        // in views that directly access $settings->field.
        if (!$settings) {
            $settings = new Setting();
        }

        if ($settings && isset($settings->ably_key) && $settings->ably_key !== null) {
            Config::set('app.ably_key', $settings->ably_key ?: config('app.ably_key'));
        }

        view()->share('appSettings', $settings);
        view()->share('settings', $settings);
    }
}
