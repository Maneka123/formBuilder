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

Route::view('/forms', 'forms')->name('forms');
Route::view('/form-builder', 'form-builder')->name('form-builder');
Route::view('/submissions', 'submissions')->name('submissions');
Route::view('/preview', 'preview')->name('preview');
Route::view('/settings', 'settings')->name('settings');
