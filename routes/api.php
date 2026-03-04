<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoint untuk Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);

// Endpoint untuk 
Route::get('/products/search', [ProductController::class, 'search']);
Route::post('/products/update-stock', [ProductController::class, 'updateStock']);
Route::get('/inventory/value', [ProductController::class, 'totalValue']);

Route::apiResource('products', ProductController::class);
