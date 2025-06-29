<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MobilController;
use App\Http\Controllers\Api\PaketController;
use App\Http\Controllers\Api\DestinasiController;
use App\Http\Controllers\Api\FaqController;

// Route untuk login (POST /api/login)
Route::post('/login', [UserController::class, 'login']);

// Route untuk resource /users (POST /api/users untuk Register, GET, PUT, DELETE)
Route::apiResource('/users', UserController::class);

// Route yang dilindungi oleh autentikasi Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Route untuk logout (POST /api/logout)
    Route::post('/logout', [UserController::class, 'logout']); // <-- NEW LOGOUT ROUTE

    // Contoh: Jika ada endpoint lain yang hanya bisa diakses setelah login
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
});

// RESTful API Resources (yang tidak perlu autentikasi untuk GET/INDEX)
// Jika kamu ingin semua endpoint ini dilindungi, kamu bisa memindahkannya ke dalam grup middleware 'auth:sanctum'
Route::apiResource('/mobils', MobilController::class);
Route::apiResource('/pakets', PaketController::class);
Route::apiResource('/destinasis', DestinasiController::class);
Route::apiResource('/faqs', FaqController::class);

// ... jika ada route lain ...