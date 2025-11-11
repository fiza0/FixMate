use App\Http\Controllers\Api\HandymanApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\ReviewApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bookings', [BookingApiController::class, 'store']);
    Route::get('/bookings', [BookingApiController::class, 'index']);
    Route::put('/bookings/{id}/status', [BookingApiController::class, 'updateStatus']);

    Route::post('/reviews', [ReviewApiController::class, 'store']);
});


Route::get('/handymen', [HandymanApiController::class, 'index']);
Route::get('/handymen/{id}', [HandymanApiController::class, 'show']);
