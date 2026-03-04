<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;


Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/inventory/value', [ProductController::class, 'totalValue']);

Route::apiResource('products', ProductController::class)->only(['index', 'show']);

Route::middleware('auth:api')->group(function () {

    Route::post('/categories', [CategoryController::class, 'store']);

    Route::post('/products/update-stock', [ProductController::class, 'updateStock']);

    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    
});