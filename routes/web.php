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

Route::get('/register', function () {
    return view('auth.register');
})->name('auth.register');

Route::post('register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/login', function () {
    return view('auth.login');
})->name('auth.login');

Route::post('login', [AuthController::class, 'login'])->name('auth.login');