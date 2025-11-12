<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\HandymanBookingController;
use App\Http\Controllers\Api\HandymanController;
use App\Http\Controllers\Api\ServiceSearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    
    // Public routes
    Route::get('/search/handymen', [ServiceSearchController::class, 'search']);
    Route::get('/handymen/{handyman}', [HandymanController::class, 'show']);

    // Protected routes
    Route::middleware(['auth:sanctum'])->group(function () {
        
        // Customer booking routes
        Route::prefix('bookings')->group(function () {
            Route::get('/', [BookingController::class, 'index']);
            Route::post('/', [BookingController::class, 'store']);
            Route::get('/{booking}', [BookingController::class, 'show']);
            Route::post('/{booking}/cancel', [BookingController::class, 'cancel']);
        });

        // Handyman booking routes
        Route::prefix('handyman/bookings')->group(function () {
            Route::get('/', [HandymanBookingController::class, 'index']);
            Route::post('/{booking}/accept', [HandymanBookingController::class, 'accept']);
            Route::post('/{booking}/decline', [HandymanBookingController::class, 'decline']);
            Route::patch('/{booking}/status', [HandymanBookingController::class, 'updateStatus']);
        });
    });
});