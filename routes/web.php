<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\GuruController;

// Health check (Render pings this every 10s)
Route::get('/up', [ApiController::class, 'health'])->name('health');

// Public routes
Route::get('/',                    [HomeController::class, 'index'])->name('home');
Route::get('/article/{slug}',      [ArticleController::class, 'show'])->name('article.show');
Route::get('/category/{cat}',      [ArticleController::class, 'category'])->name('category')->where('cat','[a-z]+');
Route::get('/search',              [ArticleController::class, 'category'])->name('search')->defaults('cat','all');
Route::get('/events',              [EventController::class, 'index'])->name('events.index');

// Auth
require __DIR__.'/auth.php';

// Authenticated
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',                    [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/write',                        [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles',                    [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit',      [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}',           [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/articles/{article}/publish',  [ArticleController::class, 'publish'])->name('articles.publish');
    Route::delete('/articles/{article}',        [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::post('/events',                      [EventController::class, 'store'])->name('events.store');
    Route::post('/events/{event}/approve',      [EventController::class, 'approve'])->name('events.approve');
    Route::patch('/admin/users/{user}/role',    [DashboardController::class, 'updateUserRole'])->name('users.role');

    // Advertisements
    Route::get('/admin/ads',              [AdvertisementController::class, 'index'])->name('ads.index');
    Route::get('/admin/ads/create',       [AdvertisementController::class, 'create'])->name('ads.create');
    Route::post('/admin/ads',             [AdvertisementController::class, 'store'])->name('ads.store');
    Route::get('/admin/ads/{ad}/edit',    [AdvertisementController::class, 'edit'])->name('ads.edit');
    Route::put('/admin/ads/{ad}',         [AdvertisementController::class, 'update'])->name('ads.update');
    Route::post('/admin/ads/{ad}/toggle', [AdvertisementController::class, 'toggle'])->name('ads.toggle');
    Route::delete('/admin/ads/{ad}',      [AdvertisementController::class, 'destroy'])->name('ads.destroy');
});

// Newsletter subscription
Route::post('/newsletter/subscribe', [ApiController::class, 'newsletter'])->name('newsletter.subscribe');

// Public ad click tracking
Route::post('/ads/{ad}/click', [AdvertisementController::class, 'click'])->name('ads.click');

// Guru AI chat
Route::post('/guru/chat', [GuruController::class, 'chat'])->name('guru.chat');

// Live API
Route::prefix('api')->group(function () {
    Route::get('/weather',     [ApiController::class, 'weather']);
    Route::get('/gold',        [ApiController::class, 'gold']);
    Route::get('/currency',    [ApiController::class, 'currency']);
    Route::get('/horoscope',   [ApiController::class, 'horoscope']);
    Route::get('/nepali-date', [ApiController::class, 'nepaliDate']);
    Route::get('/health',      [ApiController::class, 'health']);
});
