<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\Billet\BilletController;
use App\Http\Controllers\Billet\BilletProductController;
use App\Http\Controllers\Product\AttributeController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductAttributeController;
use App\Http\Controllers\Product\ProductBilletController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Order\CouponController;
use App\Http\Controllers\Order\PaymentMethodController;
use App\Http\Controllers\Order\ShippingMethodController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderProductController;
use App\Http\Controllers\Order\StatusController as OrderStatusController;
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
Route::prefix('users')->group( function () {
    Route::get('/{id}/providers', [UserController::class, 'getProviders']);
    Route::get('/{id}/products', [UserController::class, 'getProducts']);
    Route::get('/{id}/billets', [UserController::class, 'getBillets']);
    Route::get('/{id}/customers', [UserController::class, 'getCustomers']);
    Route::get('/{id}/orders', [UserController::class, 'getOrders']);
});

Route::apiResource('/providers', ProviderController::class)->middleware(['api', 'auth:sanctum']);
Route::get('/providers/{id}/billets', [ProviderController::class, 'getBillets'])->middleware(['api', 'auth:sanctum']);

Route::apiResource('/products', ProductController::class)->middleware(['api', 'auth:sanctum']);
Route::prefix('products')->group( function () {
    Route::get('/{id}/billets', [ProductBilletController::class, 'index']);
    Route::post('/{id}/billets/{billet_id}', [ProductBilletController::class, 'store']);
    Route::delete('/{id}/billets/{billet_id}', [ProductBilletController::class, 'destroy']);
    Route::get('/{id}/attributes', [ProductAttributeController::class, 'index']);
    Route::post('/{id}/attributes/{attribute_id}', [ProductAttributeController::class, 'store']);
    Route::delete('/{id}/attributes/{attribute_id}', [ProductAttributeController::class, 'destroy']);
})->middleware(['api', 'auth:sanctum']);

Route::apiResource('/billets', BilletController::class)->middleware(['api', 'auth:sanctum']);
Route::get('/billets/{id}/products', [BilletProductController::class, 'index'])->middleware(['api', 'auth:sanctum']);

Route::apiResource('/attributes', AttributeController::class)->middleware(['api', 'auth:sanctum']);

Route::apiResource('/categories', CategoryController::class)->middleware(['api', 'auth:sanctum']);
Route::get('/categories/{id}/products', [CategoryController::class, 'getProducts'])->middleware(['api', 'auth:sanctum']);

Route::apiResource('/customers', CustomerController::class)->middleware(['api', 'auth:sanctum']);
Route::get('/customers/{id}/orders', [CustomerController::class, 'getOrders'])->middleware(['api', 'auth:sanctum']);

Route::apiResource('/orders', OrderController::class)->middleware(['api', 'auth:sanctum']);
Route::prefix('orders')->group( function () {
    Route::get('/{id}/products', [OrderProductController::class, 'index']);
    Route::post('/{id}/products/{product_id}', [OrderProductController::class, 'store']);
    Route::put('/{id}/products/{product_id}', [OrderProductController::class, 'update']);
    Route::delete('/{id}/products/{product_id}', [OrderProductController::class, 'destroy']);
});

Route::apiResource('/coupons', CouponController::class)->only(['index', 'store', 'show', 'destroy'])->middleware(['api', 'auth:sanctum']);

Route::apiResource('/order-statuses', OrderStatusController::class)->only(['index', 'store', 'show', 'destroy'])->middleware(['api', 'auth:sanctum']);

Route::apiResource('/shipping-methods', ShippingMethodController::class)->only(['index', 'store', 'show', 'destroy'])->middleware(['api', 'auth:sanctum']);

Route::apiResource('/payment-methods', PaymentMethodController::class)->only(['index', 'store', 'show', 'destroy'])->middleware(['api', 'auth:sanctum']);