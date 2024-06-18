<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/out', [AuthController::class, 'logout'])->name('logout');
        Route::get('/tokens', [AuthController::class, 'tokens'])->name('tokens');
        Route::post('/out_all', [AuthController::class, 'logoutAll'])->name('logoutAll');
    });
});
