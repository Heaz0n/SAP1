<?php

use App\http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('info')->group(function () {
    Route::get('/server', [InfoController::class, 'server']);
    Route::get('/client', [InfoController::class, 'client']);
    Route::get('/database', [InfoController::class, 'database']);
});
