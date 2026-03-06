<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\LineWorkController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\ProgrammingController;
use App\Http\Controllers\Dashboard\FAQController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');
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
        Route::put('/updateAboutUs', [SettingsController::class, 'updateAboutUs'])->name('settings.updateAboutUs');
        Route::put('/updateWebsiteDesign', [SettingsController::class, 'updateWebsiteDesign'])->name('settings.updateWebsiteDesign');
        Route::post('/toggleDebugMode', [SettingsController::class, 'toggleDebugMode'])->name('settings.toggleDebugMode');
        Route::put('/updateDebugIps', [SettingsController::class, 'updateDebugIps'])->name('settings.updateDebugIps');
        Route::post('/addMyIpToDebug', [SettingsController::class, 'addMyIpToDebug'])->name('settings.addMyIpToDebug');
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

    Route::resource('clients', ClientController::class)->names('clients');
    // Client status change route
    Route::patch('/clients/{id}/status/{status}', [ClientController::class, 'changeStatus'])->name('clients.changeStatus');

    Route::resource('partners', PartnerController::class)->names('partners');
    // Partner status change route
    Route::patch('/partners/{id}/status/{status}', [PartnerController::class, 'changeStatus'])->name('partners.changeStatus');

    Route::resource('line-works', LineWorkController::class)->names('line-works');
    // LineWork status change route
    Route::patch('/line-works/{id}/status/{status}', [LineWorkController::class, 'changeStatus'])->name('line-works.changeStatus');

    Route::resource('reviews', ReviewController::class)->names('reviews');
    Route::patch('/reviews/{review}/change-status/{status}', [ReviewController::class, 'changeStatus'])->name('reviews.changeStatus');

    Route::resource('programmings', ProgrammingController::class)->names('programmings');

    Route::resource('faqs', FAQController::class)->names('faqs');
    Route::patch('/faqs/{faq}/change-status', [FAQController::class, 'changeStatus'])->name('faqs.changeStatus');

    Route::resource('tickets', TicketController::class)->names('tickets');
    Route::patch('/tickets/{ticket}/change-status/{status}', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');

    // Unified force-destroy route for all models
    Route::post('{modelClass}/{id}/force-destroy', [DashboardController::class, 'forceDestroy'])->name('forceDestroy');
});
