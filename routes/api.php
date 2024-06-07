<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('out', [AuthController::class, 'logout']);
        Route::get('tokens', [AuthController::class, 'tokens']);
        Route::post('out_all', [AuthController::class, 'logoutAll']);
    });
});
