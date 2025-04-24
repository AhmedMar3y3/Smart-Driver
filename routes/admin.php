<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\BrandsController;
use App\Http\Controllers\API\Admin\CarController;
use App\Http\Controllers\API\Admin\PlateController;
use App\Http\Controllers\API\Admin\HeroController;

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

Route::middleware('auth.admin')->group(function () {
    Route::post('logout',[AuthController::class, 'logout']);

    // brands
    Route::apiResource('brands', BrandsController::class);

    // cars
    Route::apiResource('cars',   CarController::class);

    // plates
    Route::apiResource('plates', PlateController::class);

    // hero
    Route::apiResource('heros', HeroController::class);
    Route::get('hero', [HeroController::class, 'getHero']);
});