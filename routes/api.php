<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->group( function () {
        Route::post('/registration', [AuthController::class, 'registration'])
            ->name('registration');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout')->middleware(['auth:sanctum']);
    });

Route::apiResource('/users', UserController::class)->middleware(['api', 'auth:sanctum']);

