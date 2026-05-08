<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiController;

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
    Route::get('/dashboard',                   [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/write',                       [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles',                   [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit',     [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}',          [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/articles/{article}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
    Route::delete('/articles/{article}',       [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::post('/events',                     [EventController::class, 'store'])->name('events.store');
    Route::post('/events/{event}/approve',     [EventController::class, 'approve'])->name('events.approve');
    Route::patch('/admin/users/{user}/role', function(\App\Models\User $user, \Illuminate\Http\Request $request) {
        if (!auth()->user()->isAdmin()) abort(403);
        $user->update(['role' => $request->validate(['role' => 'required|in:admin,editor,contributor,reader'])['role']]);
        return back()->with('success', 'Role updated.');
    })->name('users.role');
});

// Live API
Route::prefix('api')->group(function () {
    Route::get('/weather',     [ApiController::class, 'weather']);
    Route::get('/gold',        [ApiController::class, 'gold']);
    Route::get('/currency',    [ApiController::class, 'currency']);
    Route::get('/horoscope',   [ApiController::class, 'horoscope']);
    Route::get('/nepali-date', [ApiController::class, 'nepaliDate']);
    Route::get('/health',      fn() => response()->json(['status'=>'ok','app'=>'Nepal News Australia']));
});
// Advertisements (admin only)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/ads',              [App\Http\Controllers\AdvertisementController::class, 'index'])->name('ads.index');
    Route::get('/admin/ads/create',       [App\Http\Controllers\AdvertisementController::class, 'create'])->name('ads.create');
    Route::post('/admin/ads',             [App\Http\Controllers\AdvertisementController::class, 'store'])->name('ads.store');
    Route::get('/admin/ads/{ad}/edit',    [App\Http\Controllers\AdvertisementController::class, 'edit'])->name('ads.edit');
    Route::put('/admin/ads/{ad}',         [App\Http\Controllers\AdvertisementController::class, 'update'])->name('ads.update');
    Route::post('/admin/ads/{ad}/toggle', [App\Http\Controllers\AdvertisementController::class, 'toggle'])->name('ads.toggle');
    Route::delete('/admin/ads/{ad}',      [App\Http\Controllers\AdvertisementController::class, 'destroy'])->name('ads.destroy');
});
Route::post('/ads/{ad}/click', [App\Http\Controllers\AdvertisementController::class, 'click'])->name('ads.click');