<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * $settings is already shared globally by SettingsServiceProvider via
     * view()->share('settings', ...) using a 15-minute cache.
     * The wildcard composer that was here caused one uncached DB query per
     * rendered view (layout + partials = 10+ queries/request).
     */
    public function boot(): void
    {
        //
    }
}
