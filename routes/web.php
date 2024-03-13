<?php

use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info/server', [InfoController::class, 'getServerInfo']);
Route::get('/info/client', [InfoController::class, 'getClientInfo']);
Route::get('/info/database', [InfoController::class, 'getDatabaseInfo']);


