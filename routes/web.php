<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', fn() => view('website.welcome'))->name('welcome');
Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');

Route::get('/about-us', fn() => view('website.about-us'))->name('about-us');
Route::get('/portfolio', fn() => view('website.portfolio'))->name('portfolio');
Route::get('/works/show', fn() => view('website.workShow'))->name('works.show');
Route::get('/blog', fn() => view('website.blog'))->name('blog');
Route::get('/blog/show', fn() => view('website.blogShow'))->name('blog.show');
Route::get('/contact', fn() => view('website.contact'))->name('contact');
Route::get('/tickets', fn() => view('website.tickets'))->name('tickets');
Route::get('/website-developer', fn() => view('website.websiteDeveloper'))->name('website.developer');
Route::get('/app-mobile', fn() => view('website.appMobile'))->name('app.mobile');
Route::get('/hosting', fn() => view('website.hosting'))->name('hosting');
Route::get('/domains', fn() => view('website.domains'))->name('domains');
Route::get('/services-marketing', fn() => view('website.servicesMarketing'))->name('services.marketing');
Route::get('/seo', fn() => view('website.seo'))->name('seo');
Route::post('/cart', fn() => dd(request()->all()))->name('cart');

// Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
//     Route::post('/cache/clear', [HomeController::class, 'clearHomepageCache'])->name('admin.cache.clear');
// });

require __DIR__ . '/dashboard.php';
require __DIR__ . '/auth.php';
