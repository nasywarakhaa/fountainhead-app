<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColivingController;
use App\Http\Controllers\CafeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All responses are base64 encoded for security
|
*/

// Coliving Room API
Route::prefix('coliving')->group(function () {
    Route::post('/check-availability', [ColivingController::class, 'checkAvailability'])
        ->name('api.coliving.check-availability');
});

// Cafe Event API
Route::prefix('cafe')->group(function () {
    Route::post('/check-availability', [CafeController::class, 'checkAvailability'])
        ->name('api.cafe.check-availability');

    Route::post('/calculate-price', [CafeController::class, 'calculatePrice'])
        ->name('api.cafe.calculate-price');

    Route::get('/booking/{reference}', [CafeController::class, 'getBookingDetails'])
        ->name('api.cafe.booking-details')
        ->middleware('auth:sanctum');
});
