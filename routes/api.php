<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', function () {
        return view('register');
    });
    Route::get('/login', function () {
        return view('login');
    });
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('out', [AuthController::class, 'logout']);
        Route::get('tokens', [AuthController::class, 'tokens']);
        Route::post('out_all', [AuthController::class, 'logoutAll']);
    });
});