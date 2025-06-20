<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MobilController;
use App\Http\Controllers\Api\PaketController;
use App\Http\Controllers\Api\DestinasiController;
use App\Http\Controllers\Api\FaqController;

// RESTful API Routes
Route::apiResource('/users', UserController::class);
Route::apiResource('/mobils', MobilController::class);
Route::apiResource('/pakets', PaketController::class);
Route::apiResource('/destinasis', DestinasiController::class);
Route::apiResource('/faqs', FaqController::class);

