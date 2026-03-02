<?php

use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::post('/account/switch', [UserController::class, 'switch'])->name('account.switch')->middleware('auth');
    Route::post('{modelClass}/{id}/toggle/{field}', [DashboardController::class, 'toggleField'])->name('toggleField');

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('/content', [DashboardController::class, 'content'])->name('content');

    Route::middleware('admin')->group(function () {
        Route::put('/updateColorsWebsite', [SettingsController::class, 'updateColorsWebsite'])->name('settings.updateColorsWebsite');
        Route::put('/updateColors', [SettingsController::class, 'updateColors'])->name('settings.updateColors');
        Route::put('/updateFonts', [SettingsController::class, 'updateFonts'])->name('settings.updateFonts');
        Route::put('/updateInlinePadding', [SettingsController::class, 'updateInlinePadding'])->name('settings.updateInlinePadding');
        Route::put('/updateGeneral', [SettingsController::class, 'updateGeneral'])->name('settings.updateGeneral');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/settings2', [DashboardController::class, 'settings2'])->name('settings2');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/update', [DashboardController::class, 'updateSettings'])->name('settings.old');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/sections', [DashboardController::class, 'sections'])->name('sections');
        Route::post('/sections/update', [DashboardController::class, 'updateSections'])->name('sections.update');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/revisions', [DashboardController::class, 'revisions'])->name('revisions');
    });

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->names('users');
        Route::resource('roles', RoleController::class)->names('roles');
        Route::resource('permissions', PermissionController::class)->names('permissions');
        Route::resource('articles', ArticleController::class)->names('articles');
        // Article status change route
        Route::patch('/articles/{id}/status/{status}', [ArticleController::class, 'changeStatus'])->name('articles.changeStatus');

        Route::resource('services', ServiceController::class)->names('services');
        // Service status change route
        Route::patch('/services/{id}/status/{status}', [ServiceController::class, 'changeStatus'])->name('services.changeStatus');

        Route::resource('companies', CompanyController::class)->names('companies');
        // Company status change route
        Route::patch('/companies/{id}/status/{status}', [CompanyController::class, 'changeStatus'])->name('companies.changeStatus');
    });
});
