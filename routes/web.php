<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', function () {
    $products = \App\Models\Product::with('inventory')->get();
    return view('products.index', compact('products'));
})->name('products.index');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Social Authentication Routes
    Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
        ->name('socialite.redirect');
    
    Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])
        ->name('socialite.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Redirect /logout to home page if accessed directly
Route::get('logout', function () {
    return redirect('/');
});

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
