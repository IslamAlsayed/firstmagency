<?php

use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\DashboardsAndSystemController;
use App\Http\Controllers\Dashboard\FAQController;
use App\Http\Controllers\Dashboard\FeaturesHostingController;
use App\Http\Controllers\Dashboard\HostingPackageController;
use App\Http\Controllers\Dashboard\LineWorkController;
use App\Http\Controllers\Dashboard\OfficialDomainController;
use App\Http\Controllers\Dashboard\OurProgrammingController;
use App\Http\Controllers\Dashboard\MarketingPackageController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\PestDomainController;
use App\Http\Controllers\Dashboard\PlatformManagementController;
use App\Http\Controllers\Dashboard\ProgrammingController;
use App\Http\Controllers\Dashboard\ProjectStepController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WhyUsController;
use App\Http\Controllers\Dashboard\WorkUsStepController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');
    Route::post('/account/switch', [UserController::class, 'switch'])->name('account.switch')->middleware('auth');
    Route::post('{modelClass}/{id}/toggle/{field}', [DashboardController::class, 'toggleField'])->name('toggleField');
    Route::delete('{models}/{modelClass}/{id}/delete', [DashboardController::class, 'deleteRecord'])->name('deleteRecord');
    Route::patch('/{models}/{modelClass}/{id}/status/{status}', [DashboardController::class, 'changeStatus'])->name('models.changeStatus');
    Route::get('/content', [DashboardController::class, 'content'])->name('content');

    //! Settings Routes 
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
    Route::get('/sections', [DashboardController::class, 'sections'])->name('sections');
    Route::post('/sections/update', [DashboardController::class, 'updateSections'])->name('sections.update');
    Route::get('/revisions', [DashboardController::class, 'revisions'])->name('revisions');
    //! Temporary route for revisions view, can be removed later 

    Route::resource('users', UserController::class)->names('users');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('articles', ArticleController::class)->names('articles');
    Route::resource('services', ServiceController::class)->names('services');
    Route::resource('companies', CompanyController::class)->names('companies');
    Route::resource('clients', ClientController::class)->names('clients');
    Route::resource('line-works', LineWorkController::class)->names('line-works');
    Route::resource('partners', PartnerController::class)->names('partners');
    Route::resource('pest-domains', PestDomainController::class)->names('pest-domains');
    Route::resource('official-domains', OfficialDomainController::class)->names('official-domains');
    Route::resource('why-us', WhyUsController::class)->names('why-us');
    Route::resource('platform-management', PlatformManagementController::class)->names('platform-management');
    Route::resource('work-us-step', WorkUsStepController::class)->names('work-us-step');
    Route::resource('marketing-packages', MarketingPackageController::class)->names('marketing-packages');
    Route::resource('reviews', ReviewController::class)->names('reviews');
    Route::resource('programmings', ProgrammingController::class)->names('programmings');
    Route::resource('our-programmings', OurProgrammingController::class)->names('our-programmings');
    Route::resource('project-steps', ProjectStepController::class)->names('project-steps');
    Route::resource('features-hosting', FeaturesHostingController::class)->names('features-hosting');
    Route::resource('dashboards-and-systems', DashboardsAndSystemController::class)->names('dashboards-and-systems');
    Route::resource('hosting-packages', HostingPackageController::class)->names('hosting-packages');
    Route::resource('faqs', FAQController::class)->names('faqs');
    Route::resource('tickets', TicketController::class)->names('tickets');

    // Unified force-destroy route for all models
    Route::delete('{modelClass}/{id}/force-destroy', [DashboardController::class, 'forceDestroy'])->name('forceDestroy');
});