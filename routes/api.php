<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\TicketController;

Route::post('/reviews', [ReviewController::class, 'store'])->name('api.reviews.store');

// Ticket real-time updates - WITH session for user context
Route::middleware(['web'])->group(function () {
    Route::get('/tickets/{id}/row-html', [TicketController::class, 'getRowHtml'])->name('api.tickets.row-html');
});
