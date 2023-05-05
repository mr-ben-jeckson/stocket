<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\InventoryContorller;
use App\Http\Controllers\Api\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function() {
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'getUser']);
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::apiResource('/product', App\Http\Controllers\Api\ProductController::class);
    Route::delete('/product/gallery/remove', [\App\Http\Controllers\Api\ProductController::class, 'singleImageRemove']);
    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/tag', TagController::class);
    Route::apiResource('/inventory', InventoryContorller::class);
});

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
