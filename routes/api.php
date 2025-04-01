<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::controller(AuthController::class)->group(function () {

    Route::post('/login', 'login');
    Route::post('/signin', 'signin');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/me', 'me');
        Route::post('/refresh', 'refresh');
    });
});
