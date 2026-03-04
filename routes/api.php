<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReviewController;

Route::post('/reviews', [ReviewController::class, 'store'])->name('api.reviews.store');
