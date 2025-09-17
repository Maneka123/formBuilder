<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', fn() => redirect('/forms'));

use App\Http\Controllers\FormController;

Route::get('/form-builder/create', [FormController::class, 'create'])->name('form-builder.create');
Route::post('/form-builder', [FormController::class, 'store'])->name('form-builder.store');
Route::get('/forms/{form}/preview', [FormController::class, 'preview'])->name('forms.preview');



Route::prefix('forms')->name('forms.')->group(function () {
    Route::get('/', [FormController::class, 'index'])->name('index');
    Route::get('/create', [FormController::class, 'create'])->name('create');
    Route::post('/', [FormController::class, 'store'])->name('store');
    Route::get('/{form}/edit', [FormController::class, 'edit'])->name('edit');
    Route::put('/{form}', [FormController::class, 'update'])->name('update');
    Route::delete('/{form}', [FormController::class, 'destroy'])->name('destroy');
    Route::get('/{form}/preview', [FormController::class, 'preview'])->name('preview');
});
