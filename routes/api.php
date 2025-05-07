<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Client\CarController;
use App\Http\Controllers\API\Client\AuthController;
use App\Http\Controllers\API\Client\HomeController;
use App\Http\Controllers\API\Client\PlateController;
use App\Http\Controllers\API\Client\ReviewController;
use App\Http\Controllers\API\Client\ProfileController;
use App\Http\Controllers\API\Client\ReservationController;
use App\Http\Controllers\API\Client\SubscriptionController;

// Home routes
Route::get('emirates',      [Controller::class, 'emirates']);
Route::get('brands',        [Controller::class, 'brands']);
Route::get('categories',    [Controller::class, 'categories']);
Route::get('hero',          [HomeController::class, 'getHero']);
Route::middleware(['set-locale'])->group(function () {
    Route::get('car-packages',  [HomeController::class, 'carPackages']);
    Route::get('plate-packages', [HomeController::class, 'platePackages']);
});

// Auth routes
Route::post('/register',            [AuthController::class, 'register']);
Route::post('/login',               [AuthController::class, 'login']);

// car routes
Route::get('/cars',      [CarController::class, 'index']);
Route::get('/cars/{id}', [CarController::class, 'show']);
Route::get('/related-cars/{brandId}', [CarController::class, 'relatedCars']);

// plate routes
Route::get('/plates',      [PlateController::class, 'index']);
Route::get('/plates/{id}', [PlateController::class, 'show']);

// Captains Routes
Route::get('/captains', [ReservationController::class, 'captains']);
Route::get('/captains/{id}', [ReservationController::class, 'captain']);
Route::get('/availabilities/{id}', [ReservationController::class, 'captainAvailabilities']);
Route::get('/captain-reviews/{id}', [ReservationController::class, 'captainReviews']);

Route::middleware(['auth.client'])->group(function () {
    Route::post('/logout',              [AuthController::class, 'logout']);

    //profile routes
    Route::get('/profile',          [ProfileController::class, 'getProfile']);
    Route::post('/update-profile',  [ProfileController::class, 'updateProfile']);
    Route::post('/change-password', [ProfileController::class, 'changePassword']);
    Route::get('my-cars',           [ProfileController::class, 'myCars']);
    Route::get('my-plates',         [ProfileController::class, 'myPlates']);
    Route::post('toggle-car/{id}',  [ProfileController::class, 'toggleCarAsSold']);
    Route::post('toggle-plate/{id}',[ProfileController::class, 'togglePlateAsSold']);
    Route::get('my-reservations',   [ProfileController::class, 'myReservations']);

    // protected car and plate routes
    Route::post('/cars',       [CarController::class, 'store']);
    Route::post('/plates',     [PlateController::class, 'store']);

    // Subscription Routes
    Route::post('/subscribe',  [SubscriptionController::class, 'subscribe']);

    // Reservation Routes
    Route::post('/reserve-captain', [ReservationController::class, 'reserveCaptain']);

    // Review Routes
    Route::post('/post-review', [ReviewController::class, 'postReview']);

    // Subscribe routes
    Route::post('subscribe', [SubscriptionController::class, 'subscribeClient']);
});
