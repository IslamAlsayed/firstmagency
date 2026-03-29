<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        \App\Providers\AuthServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->web([
            \App\Http\Middleware\SetLocale::class,
            // \App\Http\Middleware\CachePageResponse::class,
        ]);

        // ✨ تسجيل الـ Middleware المخصصة للـ Dashboard
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminAccess::class,
            'superadmin' => \App\Http\Middleware\CheckSuperAdminAccess::class,
            'dashboard' => \App\Http\Middleware\CheckDashboardAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => __('auth.unauthorized_action')
                ], 403);
            }

            return redirect()->route('dashboard.index')->withError(__('auth.forbidden'));
        });
    })->create();
