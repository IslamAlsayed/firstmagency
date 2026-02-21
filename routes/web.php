<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

Route::get('/', fn() => view('welcome'));

// Language switching route
Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');

Route::get('/about-us', fn() => view('about-us'))->name('about-us');

Route::get('/portfolio', fn() => view('portfolio'))->name('portfolio');

Route::get('/works/show', fn() => view('workShow'))->name('works.show');

Route::get('/blog', fn() => view('blog'))->name('blog');

Route::get('/blog/show', fn() => view('blogShow'))->name('blog.show');

Route::get('/contact', fn() => view('contact'))->name('contact');

Route::get('/tickets', fn() => view('tickets'))->name('tickets');

Route::get('/website-developer', fn() => view('websiteDeveloper'))->name('website.developer');

Route::get('/app-mobile', fn() => view('appMobile'))->name('app.mobile');

Route::get('/hosting', fn() => view('hosting'))->name('hosting');
