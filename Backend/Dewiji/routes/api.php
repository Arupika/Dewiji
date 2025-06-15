<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\RentalCarController;
use App\Http\Controllers\HolidayPackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RentalOrderController;
use App\Http\Controllers\HolidayPackageOrderController;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('destinations', DestinationController::class);
Route::apiResource('rental-cars', RentalCarController::class);
Route::apiResource('holiday-packages', HolidayPackageController::class);

// Protected (optional pakai auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('rental-orders', RentalOrderController::class);
    Route::apiResource('holiday-orders', HolidayPackageOrderController::class);

    Route::put('rental-orders/{id}/status', [RentalOrderController::class, 'updateStatus']);
    Route::put('holiday-orders/{id}/status', [HolidayPackageOrderController::class, 'updateStatus']);
});
