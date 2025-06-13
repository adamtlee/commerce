<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SaleItemController;
use App\Http\Controllers\Api\V1\WaitlistController;
use App\Http\Controllers\Api\V1\InventoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Test route without auth
Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

// API v1 Routes
Route::prefix('v1')->group(function () {
    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    // Sale Items
    Route::get('/sale-items', [SaleItemController::class, 'index']);
    Route::get('/sale-items/{saleItem}', [SaleItemController::class, 'show']);

    // Waitlists
    Route::get('/waitlists', [WaitlistController::class, 'index']);
    Route::get('/waitlists/{waitlist}', [WaitlistController::class, 'show']);

    // Inventories
    Route::get('/inventories', [InventoryController::class, 'index']);
    Route::get('/inventories/{inventory}', [InventoryController::class, 'show']);
}); 