<?php

// routes/web.php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// Home Page
Route::get('/', [PortfolioController::class, 'index'])->name('home');

// Projects Routes
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [PortfolioController::class, 'projects'])->name('index');
    Route::get('/{slug}', [PortfolioController::class, 'projectDetail'])->name('show');
});

// About Page
Route::get('/about', [PortfolioController::class, 'about'])->name('about');

// Contact Routes
Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', [PortfolioController::class, 'contact'])->name('index');
    Route::post('/submit', [PortfolioController::class, 'submitContact'])->name('submit');
});

// Services Page
Route::get('/services', [PortfolioController::class, 'services'])->name('services');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Resume Download
Route::get('/download-resume', [PortfolioController::class, 'downloadResume'])->name('download.resume');

// Sitemap
Route::get('/sitemap.xml', [PortfolioController::class, 'sitemap'])->name('sitemap');

// Robots.txt
Route::get('/robots.txt', [PortfolioController::class, 'robots'])->name('robots');

// Manifest (PWA)
Route::get('/site.webmanifest', [PortfolioController::class, 'manifest'])->name('manifest');

// RSS Feed
Route::get('/feed', [PortfolioController::class, 'feed'])->name('feed');


// Health Check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
        'version' => config('app.version', '1.0.0'),
        'environment' => app()->environment(),
    ]);
})->name('health');

// Ping (Lightweight health check for uptime monitoring)
Route::get('/ping', function () {
    return response('pong', 200)->header('Content-Type', 'text/plain');
})->name('ping');

// Fallback 404 - HARUS di paling bawah
Route::fallback(function () {
    return response()->view('pages.errors.404', [], 404);
});