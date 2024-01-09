<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Billet\BilletController;
use App\Http\Controllers\Billet\BilletProductController;
use App\Http\Controllers\Product\ProductBilletController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group( function () {
        Route::post('/registration', [RegistrationController::class, 'registration'])
            ->name('registration');

        Route::post('/login', [LoginController::class, 'login'])
            ->name('login');

        Route::post('/logout', [LogoutController::class, 'logout'])
            ->name('logout')->middleware(['auth:sanctum']);
});


Route::apiResource('/users', UserController::class)->middleware(['api', 'auth:sanctum']);



Route::apiResource('/products', ProductController::class);

Route::prefix('products')->group( function () {
    Route::get('/{id}/billet', [ProductBilletController::class, 'index']);
    Route::post('/{id}/billet/{billet_id}', [ProductBilletController::class, 'store']);
    Route::delete('/{id}/billet/{billet_id}', [ProductBilletController::class, 'destroy']);
})->middleware(['api', 'auth:sanctum']);


Route::apiResource('/billets', BilletController::class);

Route::prefix('billets')->group( function () {
    Route::get('/{id}/product', [BilletProductController::class, 'index']);
    Route::post('/{id}/product/{product_id}', [BilletProductController::class, 'store']);
    Route::delete('/{id}/product/{product_id}', [BilletProductController::class, 'destroy']);
})->middleware(['api', 'auth:sanctum']);

