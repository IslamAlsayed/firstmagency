<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');
// Language switching route
