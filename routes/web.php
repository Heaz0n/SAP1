<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('info')->group(function () {
    Route::get('server', [InfoController::class, 'serverInfo']);
    Route::get('client', [InfoController::class, 'clientInfo']);
    Route::get('database', [InfoController::class, 'databaseInfo']);
});
