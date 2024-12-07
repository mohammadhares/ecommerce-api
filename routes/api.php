<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ModifierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
Route::prefix('public')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('blogs', [BlogController::class, 'index']);
    Route::post('contact', [ContactController::class, 'store']);

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('/check-reset-code', [UserController::class, 'checkResetCode']);
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
});

Route::middleware([JwtMiddleware::class])->group(function () {
    // User Routes
    Route::get('me', [UserController::class, 'me']);
    Route::post('logout', [UserController::class, 'logout']);

    // Category routes
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category/{id}', [CategoryController::class, 'show']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::patch('category/{id}', [CategoryController::class, 'update']);
    Route::delete('category/{id}', [CategoryController::class, 'destroy']);

    // Product routes
    Route::get('products', [ProductController::class, 'index']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::post('product', [ProductController::class, 'store']);
    Route::put('product/{id}', [ProductController::class, 'update']);
    Route::delete('product/{id}', [ProductController::class, 'destroy']);

    // Gallery routes
    Route::get('galleries', [GalleryController::class, 'index']);
    Route::get('gallery/{id}', [GalleryController::class, 'show']);
    Route::post('gallery', [GalleryController::class, 'store']);
    Route::put('gallery/{id}', [GalleryController::class, 'update']);
    Route::delete('gallery/{id}', [GalleryController::class, 'destroy']);

    // Modifiers routes
    Route::get('modifiers', [ModifierController::class, 'index']);
    Route::get('modifier/{id}', [ModifierController::class, 'show']);
    Route::post('modifier', [ModifierController::class, 'store']);
    Route::put('modifier/{id}', [ModifierController::class, 'update']);
    Route::delete('modifier/{id}', [ModifierController::class, 'destroy']);

    // Payment Card routes
    Route::get('payment-cards', [PaymentCardController::class, 'index']);
    Route::get('payment-card/{id}', [PaymentCardController::class, 'show']);
    Route::post('payment-card', [PaymentCardController::class, 'store']);
    Route::put('payment-card/{id}', [PaymentCardController::class, 'update']);
    Route::delete('payment-card/{id}', [PaymentCardController::class, 'destroy']);

    // Payment routes
    Route::get('payments', [PaymentController::class, 'index']);
    Route::get('payment/{id}', [PaymentController::class, 'show']);
    Route::post('payment', [PaymentController::class, 'store']);
    Route::put('payment/{id}', [PaymentController::class, 'update']);
    Route::delete('payment/{id}', [PaymentController::class, 'destroy']);

    // Customers routes
    Route::get('customers', [CustomerController::class, 'index']);
    Route::get('customer/{id}', [CustomerController::class, 'show']);
    Route::post('customer', [CustomerController::class, 'store']);
    Route::put('customer/{id}', [CustomerController::class, 'update']);
    Route::delete('customer/{id}', [CustomerController::class, 'destroy']);

    // Customers Address routes
    Route::get('customer-addresses', [CustomerAddressController::class, 'index']);
    Route::get('customer-address/{id}', [CustomerAddressController::class, 'show']);
    Route::post('customer-address', [CustomerAddressController::class, 'store']);
    Route::put('customer-address/{id}', [CustomerAddressController::class, 'update']);
    Route::delete('customer-address/{id}', [CustomerAddressController::class, 'destroy']);

    // Cart routes
    Route::get('carts', [CartController::class, 'index']);
    Route::get('cart/{id}', [CartController::class, 'show']);
    Route::post('cart', [CartController::class, 'store']);
    Route::put('cart/{id}', [CartController::class, 'update']);
    Route::delete('cart/{id}', [CartController::class, 'destroy']);

    // Order routes
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('order/{id}', [OrderController::class, 'show']);
    Route::post('order', [OrderController::class, 'store']);
    Route::put('order/{id}', [OrderController::class, 'update']);
    Route::delete('order/{id}', [OrderController::class, 'destroy']);

    // Review routes
    Route::get('reviews', [ReviewController::class, 'index']);
    Route::get('review/{id}', [ReviewController::class, 'show']);
    Route::post('review', [ReviewController::class, 'store']);
    Route::put('review/{id}', [ReviewController::class, 'update']);
    Route::delete('review/{id}', [ReviewController::class, 'destroy']);

    // Wishlist routes
    Route::get('wishlists', [WishlistController::class, 'index']);
    Route::get('wishlist/{id}', [WishlistController::class, 'show']);
    Route::post('wishlist', [WishlistController::class, 'store']);
    Route::put('wishlist/{id}', [WishlistController::class, 'update']);
    Route::delete('wishlist/{id}', [WishlistController::class, 'destroy']);

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
    Route::put('blog/{id}', [BlogController::class, 'update']);
    Route::delete('blog/{id}', [BlogController::class, 'destroy']);
});
