<?php

namespace IslamAlsayed\Toasts;

use Illuminate\Support\ServiceProvider;

class ToastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'toasts');

        // Publish config
        if (file_exists(__DIR__ . '/Config/toasts.php')) {
            $this->publishes([
                __DIR__ . '/Config/toasts.php' => config_path('toasts.php'),
            ], 'toast-config');
        }

        // Publish views
        if (is_dir(__DIR__ . '/Resources/views')) {
            $this->publishes([
                __DIR__ . '/Resources/views' => resource_path('views/vendor/toasts'),
            ], 'toast-views');
        }

        // Publish CSS assets
        if (is_dir(__DIR__ . '/Resources/assets/css')) {
            $this->publishes([
                __DIR__ . '/Resources/assets/css' => public_path('vendor/toasts/css'),
            ], 'toast-css');
        }

        // Publish JS assets
        if (is_dir(__DIR__ . '/Resources/assets/js')) {
            $this->publishes([
                __DIR__ . '/Resources/assets/js' => public_path('vendor/toasts/js'),
            ], 'toast-js');
        }

        // Publish webfonts
        if (is_dir(__DIR__ . '/Resources/assets/webfonts')) {
            $this->publishes([
                __DIR__ . '/Resources/assets/webfonts' => public_path('vendor/toasts/webfonts'),
            ], 'toast-webfonts');
        }

        // Publish all assets at once
        $publishes = [];

        if (file_exists(__DIR__ . '/Config/toasts.php')) {
            $publishes[__DIR__ . '/Config/toasts.php'] = config_path('toasts.php');
        }

        if (is_dir(__DIR__ . '/Resources/views')) {
            $publishes[__DIR__ . '/Resources/views'] = resource_path('views/vendor/toasts');
        }

        if (is_dir(__DIR__ . '/Resources/assets/css')) {
            $publishes[__DIR__ . '/Resources/assets/css'] = public_path('vendor/toasts/css');
        }

        if (is_dir(__DIR__ . '/Resources/assets/js')) {
            $publishes[__DIR__ . '/Resources/assets/js'] = public_path('vendor/toasts/js');
        }

        if (is_dir(__DIR__ . '/Resources/assets/webfonts')) {
            $publishes[__DIR__ . '/Resources/assets/webfonts'] = public_path('vendor/toasts/webfonts');
        }

        if (!empty($publishes)) {
            $this->publishes($publishes, 'toast-all');
        }
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/Config/toasts.php', 'toasts');

        $this->app->singleton('toast', function () {
            return new ToastManager();
        });

        $this->commands([
            \IslamAlsayed\Toasts\Console\InjectToastViewCommand::class,
        ]);

        require_once __DIR__ . '/Helpers.php';
    }
}