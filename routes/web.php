<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');
// Language switching route

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/portfolio', function () {
    return view('portfolio');
})->name('portfolio');

Route::get('/works/show', function () {
    return view('workShow');
})->name('works.show');


Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/blog/show', function () {
    return view('blogShow');
})->name('blog.show');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/tickets', function () {
    return view('tickets');
})->name('tickets');

Route::get('/website-developer', function () {
    return view('websiteDeveloper');
})->name('website.developer');

Route::get('/app-mobile', function () {
    return view('appMobile');
})->name('app.mobile');
