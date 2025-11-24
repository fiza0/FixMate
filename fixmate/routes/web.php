<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HandymanSearchController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HandymanProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public landing page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (Breeze default)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Booking + status routes (Phase 2)
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{handyman}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('bookings.accept');
    Route::post('/bookings/{booking}/start', [BookingController::class, 'start'])->name('bookings.start');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
});

// Public handyman search/listing
Route::get('/handymen', [HandymanSearchController::class, 'index'])->name('handymen.index');
// Admin dashboard + users (admin only)
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');


    Route::post('/admin/handymen/{handymanProfile}/verify', [AdminController::class, 'verifyHandyman'])
        ->name('admin.handymen.verify');


    Route::post('/admin/users/{user}/toggle', [AdminController::class, 'toggleUser'])
        ->name('admin.users.toggle');


    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])
        ->name('admin.users.destroy');


    Route::get('/admin/users/create', [AdminController::class, 'createUser'])
        ->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])
        ->name('admin.users.store');
});
});

// Reviews (homeowner)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])
        ->name('reviews.create');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])
        ->name('reviews.store');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/handyman/profile/edit', [HandymanProfileController::class, 'edit'])->name('handyman.profile.edit');
    Route::post('/handyman/profile', [HandymanProfileController::class, 'update'])->name('handyman.profile.update');
});

// Breeze auth routes
require __DIR__.'/auth.php';
