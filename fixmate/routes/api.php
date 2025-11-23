<?php

use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\HandymanApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and are assigned
| to the "api" middleware group. Make something great!
|
*/

// Example current user endpoint (optional, Breeze/Sanctum-style)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected API routes for the FixMate app
Route::middleware('auth:sanctum')->group(function () {
    // Handyman search/list API
    Route::get('/handymen', [HandymanApiController::class, 'index']);

    // Bookings API
    Route::get('/bookings', [BookingApiController::class, 'index']);
    Route::post('/bookings', [BookingApiController::class, 'store']);
});
