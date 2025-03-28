<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Client\CarController;
use App\Http\Controllers\API\Client\AuthController;
use App\Http\Controllers\API\Client\PlateController;
use App\Http\Controllers\Controller;

// Dropdown routes
Route::get('/emirates',[Controller::class, 'emirates']);
Route::get('/brands',  [Controller::class, 'brands']);

Route::post('/register',            [AuthController::class, 'register']);
Route::post('/login',               [AuthController::class, 'login']);
Route::get('/auth/google',          [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware(['auth.client'])->group(function () {
    Route::post('/logout',              [AuthController::class, 'logout']);

    
    Route::get('/cars',      [CarController::class, 'index']);
    Route::get('/cars/{id}', [CarController::class, 'show']);
    Route::post('/cars',     [CarController::class, 'store']);

    // Plate Routes
    Route::get('/plates',      [PlateController::class, 'index']);
    Route::get('/plates/{id}', [PlateController::class, 'show']);
    Route::post('/plates',     [PlateController::class, 'store']);
});

