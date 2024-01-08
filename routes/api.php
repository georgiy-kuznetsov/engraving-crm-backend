<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->group( function () {
        Route::post('/registration', [RegistrationController::class, 'registration'])
            ->name('registration');

        Route::post('/login', [LoginController::class, 'login'])
            ->name('login');

        Route::post('/logout', [LogoutController::class, 'logout'])
            ->name('logout')->middleware(['auth:sanctum']);
    });

Route::apiResource('/users', UserController::class)->middleware(['api', 'auth:sanctum']);

