<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AppMobileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServicesMarketingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');

Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/portfolio/{id}/{slug?}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/blog', [ArticleController::class, 'index'])->name('blog');
Route::get('/blog/category/{id}', [ArticleController::class, 'category'])->name('blog.category');
Route::get('/blog/{id}/{slug?}', [ArticleController::class, 'show'])->name('blog.show');
Route::get('/website-developer', [WebsiteController::class, 'index'])->name('website.developer');
Route::get('/website-developer/{slug}', [WebsiteController::class, 'show'])->name('website.developer.show');
Route::get('/app-mobile', [AppMobileController::class, 'index'])->name('app.mobile');
Route::get('/hosting', [HostingController::class, 'index'])->name('hosting');
Route::get('/domains', [DomainController::class, 'index'])->name('domains');
Route::get('/services-marketing', [ServicesMarketingController::class, 'index'])->name('services.marketing');

Route::get('/tickets/inquiry', [TicketController::class, 'inquiry'])->name('tickets.inquiry');
Route::post('/tickets/message/{uuid}', [TicketController::class, 'message'])->name('tickets.message');
Route::put('/tickets/messages/{messageId}', [TicketController::class, 'updateMessage'])->name('tickets.messages.update');
Route::delete('/tickets/messages/{messageId}', [TicketController::class, 'deleteMessage'])->name('tickets.messages.delete');
Route::post('/tickets/generate-verification', [TicketController::class, 'generateNewVerification'])->name('tickets.generate-verification');
Route::get('/tickets/support_pro_rating/{ticketId}/{token}', [TicketController::class, 'supportProRating'])->name('tickets.support_pro_rating');
Route::post('/tickets/rating/{ticketId}/{token}', [TicketController::class, 'storeRating'])->name('tickets.store-rating');
Route::resource('/tickets', TicketController::class)->names('tickets');
Route::get('/ably-test', [TicketController::class, 'ablyTest'])->name('ably-test');

Route::get('/seo', fn() => view('website.seo'))->name('seo');
Route::post('/cart', fn() => dd(request()->all()))->name('cart');

Route::post('/reviews', fn(\Illuminate\Http\Request $request) => response()->json([
    'success' => true,
    'message' => 'تم استقبال المراجعة',
    'data' => $request->all()
], 200))->name('reviews.store');

require __DIR__ . '/dashboard.php';
require __DIR__ . '/auth.php';
