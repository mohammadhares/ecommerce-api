<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

    Route::prefix('public')->group(function () {
        Route::get('categories', [CategoryController::class, 'index']);

        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
        Route::post('/check-reset-code', [UserController::class, 'checkResetCode']);
        Route::post('/reset-password', [UserController::class, 'resetPassword']);
    });

Route::middleware([JwtMiddleware::class])->group(function () {

    // Category routes
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category/{id}', [CategoryController::class, 'show']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::patch('category/{id}', [CategoryController::class, 'update']);
    Route::delete('category/{id}', [CategoryController::class, 'destroy']);


    Route::get('user', [UserController::class, 'getUser']);
    Route::get('me', [UserController::class, 'me']);
    Route::post('logout', [UserController::class, 'logout']);
});
