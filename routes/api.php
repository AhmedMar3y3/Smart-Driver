<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Client\CarController;
use App\Http\Controllers\API\Client\AuthController;
use App\Http\Controllers\API\Client\HeroController;
use App\Http\Controllers\API\Client\PlateController;
use App\Http\Controllers\API\Client\ProfileController;
use App\Http\Controllers\API\Client\SubscriptionController;

// Dropdown routes
Route::get('/emirates',[Controller::class, 'emirates']);
Route::get('/brands',  [Controller::class, 'brands']);
Route::get('/hero', [HeroController::class, 'getHero']);

// Auth routes
Route::post('/register',            [AuthController::class, 'register']);
Route::post('/login',               [AuthController::class, 'login']);

// car routes
Route::get('/cars',      [CarController::class, 'index']);
Route::get('/cars/{id}', [CarController::class, 'show']);
Route::get('/related-cars/{brandId}',[CarController::class, 'relatedCars']);

// plate routes
Route::get('/plates',      [PlateController::class, 'index']);
Route::get('/plates/{id}', [PlateController::class, 'show']);


Route::middleware(['auth.client'])->group(function () {
    Route::post('/logout',              [AuthController::class, 'logout']);

    //profile routes
    Route::get('/profile',          [ProfileController::class, 'getProfile']);
    Route::post('/update-profile',  [ProfileController::class, 'updateProfile']);
    Route::post('/change-password', [ProfileController::class, 'changePassword']);

    // protected car and plate routes
    Route::post('/cars',       [CarController::class, 'store']);
    Route::post('/plates',     [PlateController::class, 'store']);

    // Subscription Routes
    Route::post('/subscribe',  [SubscriptionController::class, 'subscribe']);
});