<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

    Route::prefix('public')->group(function () {
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
        Route::post('/check-reset-code', [UserController::class, 'checkResetCode']);
        Route::post('/reset-password', [UserController::class, 'resetPassword']);
    });

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [UserController::class, 'getUser']);
    Route::get('me', [UserController::class, 'me']);
    Route::post('logout', [UserController::class, 'logout']);
});
