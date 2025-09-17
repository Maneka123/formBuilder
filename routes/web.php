<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SubmissionController;

// Redirect root to /forms
Route::get('/', fn() => redirect('/forms'));

// Form Builder Routes
Route::prefix('form-builder')->group(function () {
    Route::get('/create', [FormController::class, 'create'])->name('form-builder.create');
    Route::post('/', [FormController::class, 'store'])->name('form-builder.store');
});

// Main Form Routes
Route::prefix('forms')->name('forms.')->group(function () {
    Route::get('/', [FormController::class, 'index'])->name('index');
    Route::get('/create', [FormController::class, 'create'])->name('create');
    Route::post('/', [FormController::class, 'store'])->name('store');
    Route::get('{form}/edit', [FormController::class, 'edit'])->name('edit');
    Route::put('{form}', [FormController::class, 'update'])->name('update');
    Route::delete('{form}', [FormController::class, 'destroy'])->name('destroy');
    Route::get('{form}/preview', [FormController::class, 'preview'])->name('preview');

    // User-facing form submission
    Route::get('{form}/submit', [FormController::class, 'show'])->name('submit');
    Route::post('{form}/submit', [FormController::class, 'submit'])->name('submit.store');

    // Submissions routes
    Route::get('{form}/submissions', [SubmissionController::class, 'index'])->name('submissions');
    Route::get('{form}/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');

    
});
Route::get('/submissions', [SubmissionController::class, 'allSubmissions'])->name('submissions.all');
