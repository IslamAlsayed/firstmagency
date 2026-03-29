<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),
    'whatsapp' => env('APP_WHATSAPP', '1234567890'),
    'phone' => env('APP_PHONE', '1234567890'),
    'email' => env('APP_EMAIL', 'info@example.com'),
    'ably_key' => env('ABLY_KEY', ''),
    'start_work_time' => env('START_WORK_TIME', ''),
    'end_work_time' => env('END_WORK_TIME', ''),
    'cache_time' => env('CACHE_TIME', 300),

    /*
    |--------------------------------------------------------------------------
    | Cross-Device & Multi-Domain Configuration
    |--------------------------------------------------------------------------
    | 
    | Dynamic URLs for supporting multiple domains and environments
    */

    'whatsapp_link' => env('APP_WHATSAPP_LINK', 'https://wa.me/201212601601'),
    'phone_link' => env('APP_PHONE_LINK', 'tel:+201212601601'),
    'client_portal_url' => env('APP_CLIENT_PORTAL_URL', 'https://client.firstmagency.com'),
    'support_images' => [
        'logo' => env('APP_SUPPORT_IMAGE_LOGO', '/assets/images/website/reviews-bg.jpg'),
        'sales' => env('APP_SUPPORT_IMAGE_SALES', '/assets/images/website/support/sales.png'),
        'tickets' => env('APP_SUPPORT_IMAGE_TICKETS', '/assets/images/website/support/tickets.png'),
        'phone' => env('APP_SUPPORT_IMAGE_PHONE', '/assets/images/website/support/phone.png'),
        'account' => env('APP_SUPPORT_IMAGE_ACCOUNT', '/assets/images/website/support/account.png'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'Africa/Cairo'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'ar'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'ar'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
