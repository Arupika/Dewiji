<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User; // Pastikan model ini di-import

Route::middleware('api')->group(function () {
    Route::get('/health', function () {
        return response()->json(['status' => 'ok']);
    });

    Route::get('/version', function () {
        return response()->json(['version' => config('app.version')]);
    });

    // Add more API routes here
    Route::get('/users', function (Request $request) {
    $users = User::all(); // Ambil semua user dari database
    return response()->json(['users' => $users]);
});
});