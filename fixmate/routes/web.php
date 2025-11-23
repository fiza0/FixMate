<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HandymanSearchController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Homewoner, submit a review
    Route::post('/bookings/{booking}/review',[ReviewController::class,'store'])->name('reviews.store');
});

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // GET /admin/users (index)​
    // GET /admin/users/{user}/edit (edit)​
    // PUT /admin/users/{user} (update)​
    // DELETE /admin/users/{user} (destroy)
    Route::resource('admin/users', AdminController::class)->except(['create','store','show']);


    //Veifying a handyman
    Route::post('/admin/users/{user}/verify',[AdminController::class,'verifyHandyman'])->name('admin.users.verify');
    //un-verifying a handyman
    Route::post('/admin/users/{user}/unverify',[AdminController::class,'unverifyHandyman'])->name('admin.users.unverify');
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

// Auth routes
require __DIR__.'/auth.php';
