<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReviewController as LegacyReviewController;
use App\Http\Controllers\Api\TicketController as LegacyTicketController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Public\ArticleController;
use App\Http\Controllers\Api\V1\Public\PortfolioController;
use App\Http\Controllers\Api\V1\Public\ReviewController;
use App\Http\Controllers\Api\V1\Public\ServiceController;
use App\Http\Controllers\Api\V1\Public\ProjectController;
use App\Http\Controllers\Api\V1\Public\FAQController;
use App\Http\Controllers\Api\V1\Public\HomeController;
use App\Http\Controllers\Api\V1\Ticket\TicketController;
use App\Http\Controllers\Api\V1\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Api\V1\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\V1\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Api\V1\Admin\ReviewController as AdminReviewController;

// ─── Legacy (internal use) ─────────────────────────────────────────────────
Route::post('/reviews', [LegacyReviewController::class, 'store'])->name('api.reviews.store');

Route::middleware(['web'])->group(function () {
    Route::get('/tickets/{id}/row-html', [LegacyTicketController::class, 'getRowHtml'])->name('api.tickets.row-html');
});

// ─── V1 API ────────────────────────────────────────────────────────────────
Route::prefix('v1')->name('api.v1.')->group(function () {

    // ── Auth ────────────────────────────────────────────────────────────────
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('me', [AuthController::class, 'me'])->name('me');
            Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        });
    });

    // ── Public Content ──────────────────────────────────────────────────────
    Route::middleware('throttle:60,1')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('home');

        Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

        Route::get('portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
        Route::get('portfolio/{id}', [PortfolioController::class, 'show'])->name('portfolio.show');

        Route::get('services', [ServiceController::class, 'index'])->name('services.index');

        Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/{id}', [ProjectController::class, 'show'])->name('projects.show');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('reviews', [ReviewController::class, 'store'])
            ->middleware('throttle:10,1')
            ->name('reviews.store');

        Route::get('faqs', [FAQController::class, 'index'])->name('faqs.index');
    });

    // ── Tickets (public, token-based) ───────────────────────────────────────
    Route::prefix('tickets')->name('tickets.')->middleware('throttle:10,1')->group(function () {
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('rating/{ticketId}/{token}', [TicketController::class, 'showRating'])->name('rating.show');
        Route::post('rating/{ticketId}/{token}', [TicketController::class, 'storeRating'])->name('rating.store');
        Route::get('{uuid}', [TicketController::class, 'show'])->name('show');
        Route::post('{uuid}/messages', [TicketController::class, 'storeMessage'])->name('messages.store');
        Route::put('messages/{messageId}', [TicketController::class, 'updateMessage'])->name('messages.update');
        Route::delete('messages/{messageId}', [TicketController::class, 'deleteMessage'])->name('messages.delete');
    });

    // ── Admin (Sanctum + Admin role) ────────────────────────────────────────
    Route::middleware(['auth:sanctum', 'api.admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Tickets
            Route::get('tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
            Route::post('tickets', [AdminTicketController::class, 'store'])->name('tickets.store');
            Route::get('tickets/deleted', [AdminTicketController::class, 'deleted'])->name('tickets.deleted');
            Route::get('tickets/{id}', [AdminTicketController::class, 'show'])->name('tickets.show');
            Route::put('tickets/{id}', [AdminTicketController::class, 'update'])->name('tickets.update');
            Route::delete('tickets/{id}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
            Route::patch('tickets/{id}/restore', [AdminTicketController::class, 'restore'])->name('tickets.restore');
            Route::post('tickets/{id}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
            Route::post('tickets/{id}/send-copy', [AdminTicketController::class, 'sendCopy'])->name('tickets.sendCopy');

            // Users
            Route::apiResource('users', AdminUserController::class);

            // Articles
            Route::apiResource('articles', AdminArticleController::class);

            // Reviews
            Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
            Route::put('reviews/{id}', [AdminReviewController::class, 'update'])->name('reviews.update');
            Route::delete('reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
        });
});
