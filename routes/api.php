<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categories;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('/products', ProductController::class);
Route::apiResource('/categories', Categories::class);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function(){
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/categories', Categories::class);
});

