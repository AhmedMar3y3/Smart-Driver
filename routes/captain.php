<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Captain\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth.captain']);

Route::middleware(['auth.captain'])->group(function () {
    // Add protected routes here
});