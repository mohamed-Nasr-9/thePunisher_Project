<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\Auth\InvitationController;

// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:api')->group(function () {
//     Route::get('me', [AuthController::class, 'me']);
//     Route::post('logout', [AuthController::class, 'logout']);
// });


// Route::prefix('auth')->group(function () {

//     Route::post('register', [AuthController::class, 'register']);
//     Route::post('login', [AuthController::class, 'login']);

//     Route::post('forgot-password', [PasswordController::class, 'forgot']);
//     Route::post('reset-password', [PasswordController::class, 'reset']);

//     Route::middleware('auth:api')->group(function () {
//         Route::get('me', [AuthController::class, 'me']);
//         Route::post('logout', [AuthController::class, 'logout']);
//     });

//     Route::middleware(['auth:api', 'admin'])->group(function () {
//         Route::post('invite', [InvitationController::class, 'invite']);
//     });
// });

Route::prefix('v1/auth')->group(function () {

    // Public
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);

    // Protected
    Route::middleware('auth:api')->group(function () {
        Route::get('me',      [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::post('forgot-password', [PasswordController::class, 'forgot']);
    Route::post('reset-password',  [PasswordController::class, 'reset']);
});


Route::prefix('v1')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{slug}', [ProductController::class, 'show']);

    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{product}', [ProductController::class, 'update']);
        Route::delete('products/{product}', [ProductController::class, 'destroy']);
    });
});

Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::post('products/{product}/images', [ProductImageController::class, 'store']);
    Route::delete('products/{product}/images/{image}', [ProductImageController::class, 'destroy']);
    Route::patch('products/{product}/images/{image}/main', [ProductImageController::class, 'setMain']);
});