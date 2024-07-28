<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/logout', [AuthController::class, 'logout']);
    // ->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, "register"]);
    Route::post('/activate', [AuthController::class, "activate"]);
    Route::post('/forgot-password', [AuthController::class, "forgot_password"]);
    Route::post('/reset-password', [AuthController::class, "reset_password"]);
});

Route::prefix('users')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{code}', [UserController::class, 'update']);
    Route::delete('/{code}', [UserController::class, 'delete']);
    Route::get('/{code}', [UserController::class, 'detail']);
});

Route::prefix('profile')->name('profile')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [UserController::class, 'current_user']);
    Route::post('/', [UserController::class, 'update_profile']);
    Route::post('/update-password', [UserController::class, 'update_password']);
});
