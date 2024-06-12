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

Route::group(['prefix' => '/auth'], function () {
    Route::get('/home', function(){
        return view('welcome');
    });

    Route::post('/login', [AuthController::class, "login"]);
    Route::middleware('authcheck')->group(function() {

        Route::get('/register', function(){
            return view('welcome');
        });

        Route::post('/register', [AuthController::class, "register"]);
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/me', [AuthController::class, "me"]);
        Route::post('/out', [AuthController::class, "logout"]);
        Route::get('/tokens', [AuthController::class, "tokens"]);
        Route::post('/out_all', [AuthController::class, "logoutAll"]);
    });
});
