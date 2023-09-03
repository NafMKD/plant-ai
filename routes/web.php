<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [\App\Http\Controllers\ChatController::class, 'index'])->middleware('auth')->name('home');

Route::get('/d', [\App\Http\Controllers\ChatController::class, 'requester']);
