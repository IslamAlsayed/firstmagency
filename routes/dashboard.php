<?php

use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\BackupController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardsAndSystemController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\FAQController;
use App\Http\Controllers\Dashboard\HostingFeatureController;
use App\Http\Controllers\Dashboard\HostingPackageController;
use App\Http\Controllers\Dashboard\LineWorkController;
use App\Http\Controllers\Dashboard\MarketingPackageController;
use App\Http\Controllers\Dashboard\OfficialDomainController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\PestDomainController;
use App\Http\Controllers\Dashboard\PlatformManagementController;
use App\Http\Controllers\Dashboard\ProgrammingCategoryController;
use App\Http\Controllers\Dashboard\ProgrammingSystemController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\ProjectStepController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\SidebarController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WhyUsController;
use App\Http\Controllers\Dashboard\WorkUsStepController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('index2/', function () {
        return view('dashboard.index2');
    })->name('index2');
    Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');
    Route::post('/account/switch', [UserController::class, 'switch'])->name('account.switch')->middleware('auth');
    Route::post('{modelClass}/{id}/toggle/{field}', [DashboardController::class, 'toggleField'])->name('toggleField');
    Route::delete('{models}/{modelClass}/{id}/delete', [DashboardController::class, 'deleteRecord'])->name('deleteRecord');
    Route::patch('/{models}/{modelClass}/{id}/status/{status}', [DashboardController::class, 'changeStatus'])->name('models.changeStatus');
    Route::get('/content', [DashboardController::class, 'content'])->name('content');

    // Settings Routes 
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

    // Sidebar Preference Routes
    Route::post('/sidebar/save', [SidebarController::class, 'save'])->name('sidebar.save');
    Route::get('/sidebar/order', [SidebarController::class, 'getOrder'])->name('sidebar.order');
    Route::post('/sidebar/reset', [SidebarController::class, 'reset'])->name('sidebar.reset');

    // Database Backups Routes
    Route::get('/backups/list', [BackupController::class, 'list'])->name('backups.list');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/download/{filename}', [BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('/backups/delete', [BackupController::class, 'delete'])->name('backups.delete');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');
    Route::get('/profile/activity', [ProfileController::class, 'activity'])->name('profile.activity');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

    Route::resource('users', UserController::class)->names('users');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('articles', ArticleController::class)->names('articles');
    Route::resource('services', ServiceController::class)->names('services');
    Route::resource('projects', ProjectController::class)->names('projects');
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
    Route::resource('programming-categories', ProgrammingCategoryController::class)->names('programming-categories');
    Route::resource('programming-systems', ProgrammingSystemController::class)->names('programming-systems');
    Route::resource('project-steps', ProjectStepController::class)->names('project-steps');
    Route::resource('hosting-features', HostingFeatureController::class)->names('hosting-features');
    Route::resource('dashboards-and-systems', DashboardsAndSystemController::class)->names('dashboards-and-systems');
    Route::resource('hosting-packages', HostingPackageController::class)->names('hosting-packages');
    Route::resource('faqs', FAQController::class)->names('faqs');

    // Department Routes
    Route::resource('departments', DepartmentController::class)->names('departments');
    Route::post('departments/{department}/toggle-active', [DepartmentController::class, 'toggleActive'])->name('departments.toggle-active');
    Route::post('departments/bulk-toggle-active', [DepartmentController::class, 'bulkToggleActive'])->name('departments.bulk-toggle-active');
    Route::patch('departments/{department}/tickets/{ticket}', [DepartmentController::class, 'changeTicketDepartment'])->name('departments.change-ticket-department');

    Route::get('tickets/{ticketId}/support-reply', [TicketController::class, 'supportReply'])->name('tickets.support-reply');
    Route::post('tickets/{ticketId}/support-reply', [TicketController::class, 'postSupportReply'])->name('tickets.support-reply.store');
    Route::get('tickets/{ticketId}/send-copy', [TicketController::class, 'sendCopyToCustomer'])->name('tickets.sendCopyToCustomer');
    Route::resource('tickets', TicketController::class)->names('tickets');

    // Unified force-destroy route for all models
    Route::delete('{modelClass}/{id}/force-destroy', [DashboardController::class, 'forceDestroy'])->name('forceDestroy');
});
