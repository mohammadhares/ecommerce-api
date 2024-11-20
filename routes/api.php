<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

    Route::prefix('public')->group(function () {
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('blogs', [BlogController::class, 'index']);
        Route::post('contact', [ContactController::class, 'store']);

        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
        Route::post('/check-reset-code', [UserController::class, 'checkResetCode']);
        Route::post('/reset-password', [UserController::class, 'resetPassword']);
    });

Route::middleware([JwtMiddleware::class])->group(function () {

    //
    Route::get('me', [UserController::class, 'me']);
    Route::post('logout', [UserController::class, 'logout']);

    // Category routes
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category/{id}', [CategoryController::class, 'show']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::patch('category/{id}', [CategoryController::class, 'update']);
    Route::delete('category/{id}', [CategoryController::class, 'destroy']);

    // Contact routes
    Route::get('contacts', [ContactController::class, 'index']);
    Route::get('contact/{id}', [ContactController::class, 'show']);
    Route::post('contact', [ContactController::class, 'store']);
    Route::patch('contact/{id}', [ContactController::class, 'update']);
    Route::delete('contact/{id}', [ContactController::class, 'destroy']);

     // Blog routes
     Route::get('blogs', [BlogController::class, 'index']);
     Route::get('blog/{id}', [BlogController::class, 'show']);
     Route::post('blog', [BlogController::class, 'store']);
     Route::patch('blog/{id}', [BlogController::class, 'update']);
     Route::delete('blog/{id}', [BlogController::class, 'destroy']);



});
