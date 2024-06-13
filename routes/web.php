<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('info')->group(function () {
    Route::get('/server', [InfoController::class, 'server']);
    Route::get('/client', [InfoController::class, 'client']);
    Route::get('/database', [InfoController::class, 'database']);
});

// Страницы регистрации и логина
Route::get('/register', function () {
    return view('register');
});
Route::get('/login', function () {
    return view('login');
});