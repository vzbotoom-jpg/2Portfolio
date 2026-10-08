<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| All routes are protected by auth + admin middleware.
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // Projects Management
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');

        // Additional Actions
        Route::post('/{project}/toggle-publish', [ProjectController::class, 'togglePublish'])->name('toggle-publish');
        Route::post('/{project}/toggle-featured', [ProjectController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{project}/duplicate', [ProjectController::class, 'duplicate'])->name('duplicate');

        // Bulk Actions
        Route::post('/bulk-delete', [ProjectController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-publish', [ProjectController::class, 'bulkPublish'])->name('bulk-publish');
        Route::post('/bulk-unpublish', [ProjectController::class, 'bulkUnpublish'])->name('bulk-unpublish');

        // Reorder
        Route::post('/reorder', [ProjectController::class, 'reorder'])->name('reorder');

        // Export
        Route::get('/export/{format?}', [ProjectController::class, 'export'])->name('export');

        // Media
        Route::post('/{project}/upload-media', [ProjectController::class, 'uploadMedia'])->name('upload-media');
        Route::delete('/{project}/delete-media/{media}', [ProjectController::class, 'deleteMedia'])->name('delete-media');
    });

    // Skills Management
    Route::prefix('skills')->name('skills.')->group(function () {
        Route::get('/', [SkillController::class, 'index'])->name('index');
        Route::get('/create', [SkillController::class, 'create'])->name('create');
        Route::post('/', [SkillController::class, 'store'])->name('store');
        Route::get('/{skill}/edit', [SkillController::class, 'edit'])->name('edit');
        Route::put('/{skill}', [SkillController::class, 'update'])->name('update');
        Route::delete('/{skill}', [SkillController::class, 'destroy'])->name('destroy');

        // Bulk Actions
        Route::post('/bulk-delete', [SkillController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/reorder', [SkillController::class, 'reorder'])->name('reorder');

        // Export
        Route::get('/export/{format?}', [SkillController::class, 'export'])->name('export');
    });

    // Services Management
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');

        // Bulk Actions
        Route::post('/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/reorder', [ServiceController::class, 'reorder'])->name('reorder');
    });

    // Testimonials Management
    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/', [TestimonialController::class, 'index'])->name('index');
        Route::get('/create', [TestimonialController::class, 'create'])->name('create');
        Route::post('/', [TestimonialController::class, 'store'])->name('store');
        Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('edit');
        Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('destroy');

        // Bulk Actions
        Route::post('/bulk-delete', [TestimonialController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/{testimonial}/toggle-featured', [TestimonialController::class, 'toggleFeatured'])->name('toggle-featured');
    });

    // Messages Management
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{message}', [MessageController::class, 'show'])->name('show');
        Route::post('/{message}/mark-read', [MessageController::class, 'markRead'])->name('mark-read');
        Route::post('/{message}/reply', [MessageController::class, 'reply'])->name('reply');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');

        // Bulk Actions
        Route::post('/bulk-delete', [MessageController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-mark-read', [MessageController::class, 'bulkMarkRead'])->name('bulk-mark-read');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/', [SettingsController::class, 'update'])->name('update');
    });

    // Media Library (Optional - Stub)
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', function () {
            return view('admin.media.index');
        })->name('index');
        Route::post('/upload', function (\Illuminate\Http\Request $request) {
            return response()->json(['message' => 'Media upload endpoint'], 200);
        })->name('upload');
        Route::delete('/{media}', function () {
            return response()->json(['message' => 'Media delete endpoint'], 200);
        })->name('destroy');
    });

    // Activity Log (Optional - Stub)
    Route::prefix('activity-log')->name('activity-log.')->group(function () {
        Route::get('/', function () {
            return view('admin.activity-log.index');
        })->name('index');
        Route::delete('/clear', function () {
            return response()->json(['message' => 'Activity log cleared'], 200);
        })->name('clear');
    });

    // Backup (Optional - Stub)
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', function () {
            return view('admin.backup.index');
        })->name('index');
        Route::post('/create', function () {
            return response()->json(['message' => 'Backup created'], 200);
        })->name('create');
        Route::get('/download/{filename}', function ($filename) {
            return response()->json(['message' => 'Backup download'], 200);
        })->name('download');
    });
});