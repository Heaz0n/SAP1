<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
    Route::post('out', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('tokens', [AuthController::class, 'tokens'])->middleware('auth:api');
    Route::post('out_all', [AuthController::class, 'logoutAll'])->middleware('auth:api');
});