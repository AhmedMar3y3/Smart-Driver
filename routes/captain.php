<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Captain\HomeController;
use App\Http\Controllers\API\Captain\AuthController;
use App\Http\Controllers\API\Captain\ReviewController;
use App\Http\Controllers\API\Captain\ProfileController;
use App\Http\Controllers\API\Captain\PackageController;
use App\Http\Controllers\API\Captain\CaptainInfoController;
use App\Http\Controllers\API\Captain\ReservationController;
use App\Http\Controllers\API\Captain\AvailabilityController;
use App\Http\Controllers\API\Captain\SubscriptionController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth.captain','set-locale'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('complete-info', [CaptainInfoController::class, 'completeInfo']);
    Route::get('packages', [PackageController::class, 'captainPackages']);
    
    
    Route::post('subscribe', [SubscriptionController::class, 'subscribeCaptain']);
    
    Route::middleware(['subscription'])->group(function () {

        // Profile Routes
        Route::get('profile', [ProfileController::class, 'getProfile']);
        Route::post('change-password', [ProfileController::class, 'changePassword']);

        // Info Routes
        Route::get('info', [CaptainInfoController::class, 'show']);
        Route::post('update-info', [CaptainInfoController::class, 'update']);

        // Home Routes
        Route::get('stats', [HomeController::class, 'stats']);
        
        // Availability Routes
        Route::get('availability',        [AvailabilityController::class, 'index']);
        Route::post('availability',       [AvailabilityController::class, 'store']);
        Route::put('availability/{id}',   [AvailabilityController::class, 'update']);
        Route::delete('availability/{id}',[AvailabilityController::class, 'destroy']);

        // Reservation Routes
        Route::get('pending-reservations',    [ReservationController::class, 'pendingReservations']);
        Route::get('accepted-reservations',   [ReservationController::class, 'acceptedReservations']);
        Route::get('rejected-reservations',   [ReservationController::class, 'rejectedReservations']);
        Route::get('completed-reservations',  [ReservationController::class, 'completedReservations']);
        Route::post('aprove-reservation/{id}',[ReservationController::class, 'approveReservation']);
        Route::post('reject-reservation/{id}',[ReservationController::class, 'rejectReservation']);
        Route::post('complete-reservation/{id}',[ReservationController::class, 'completeReservation']);

        // Review Routes
        Route::get('reviews', [ReviewController::class, 'index']);

        // Subscription Routes

    });
});