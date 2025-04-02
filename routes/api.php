<?php

use App\Http\Controllers\Api\CircuitController;
use App\Http\Controllers\Api\LapController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/signin', 'signin');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/me', 'me');
        Route::post('/refresh', 'refresh');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::controller(CircuitController::class)
    ->prefix('/circuit')->group(function () {
        Route::post('/','store');
    });

    Route::controller(LapController::class)
    ->prefix('/lap')->group(function () {
        Route::post('/','store');
        Route::get('/','index');
    });

    Route::controller(ProfileController::class)
    ->prefix('/profile/laps')->group(function () {
        Route::get('/','index');
    });
});

// Route::controller(CircuitController::class)
// ->middleware('auth:api')
// ->prefix('/circuit')
// ->group(function () {
//     Route::post('/','store');
// });

// Route::controller(LapController::class)
// ->middleware('auth:api')
// ->prefix('/lap')
// ->group(function () {
//     Route::post('/','store');
//     Route::get('/','index');
// });

// Route::controller(ProfileController::class)
// ->middleware('auth:api')
// ->prefix('/profile/laps')
// ->group(function () {
//     Route::get('/','index');
// });
