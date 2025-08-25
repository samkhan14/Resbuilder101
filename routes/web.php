<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\TemplateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/myresume', function () {
    return Inertia::render('myresume');
})->name('myresume');

// PDF Generation Routes
Route::prefix('pdf')->name('pdf.')->group(function () {
    Route::get('/generate', [PdfController::class, 'showGenerateForm'])->name('generate');
    Route::post('/generate', [PdfController::class, 'generatePdf'])->name('generate-pdf');
    Route::post('/preview', [PdfController::class, 'previewPdf'])->name('preview');
    Route::get('/templates', [PdfController::class, 'getTemplates'])->name('templates');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resume management
    Route::prefix('resumes')->name('resumes.')->group(function () {
        Route::get('/', [ResumeController::class, 'index'])->name('index');
        Route::get('/create', [ResumeController::class, 'create'])->name('create');
        Route::post('/', [ResumeController::class, 'store'])->name('store');
        Route::get('/{resume}', [ResumeController::class, 'show'])->name('show');
        Route::get('/{resume}/edit', [ResumeController::class, 'edit'])->name('edit');
        Route::put('/{resume}', [ResumeController::class, 'update'])->name('update');
        Route::delete('/{resume}', [ResumeController::class, 'destroy'])->name('destroy');
        Route::post('/{resume}/duplicate', [ResumeController::class, 'duplicate'])->name('duplicate');
        Route::post('/{resume}/download', [ResumeController::class, 'download'])->name('download');
    });

    // Template selection
    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{template}', [TemplateController::class, 'show'])->name('templates.show');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('categories', AdminController::class);
        Route::resource('templates', AdminController::class);
    });
});

require __DIR__ . '/auth.php';
