<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlockCipherController;
use App\Http\Controllers\StreamCipherController;

Route::view('/', 'dashboard');
Route::view('/block-cipher', 'block-cipher');
Route::post('/block-cipher/proses', [BlockCipherController::class, 'proses']);
Route::view('/stream-cipher', 'stream-cipher');
Route::post('/stream-cipher/proses', [StreamCipherController::class, 'proses']);
Route::view('/about', 'about')->name('about');