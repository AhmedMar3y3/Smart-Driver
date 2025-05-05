<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\BrandsController;
use App\Http\Controllers\API\Admin\CarController;
use App\Http\Controllers\API\Admin\PlateController;
use App\Http\Controllers\API\Admin\HeroController;
use App\Http\Controllers\API\Admin\CaptainController;

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

Route::middleware('auth.admin')->group(function () {
    Route::post('logout',[AuthController::class, 'logout']);

    // brands
    Route::apiResource('brands', BrandsController::class)->except(['update']);
    Route::post('brands/{id}', [BrandsController::class, 'update']);

    // cars
    Route::apiResource('cars',   CarController::class);

    // plates
    Route::apiResource('plates', PlateController::class);

    // hero
    Route::apiResource('heros', HeroController::class);
    Route::get('hero', [HeroController::class, 'getHero']);

    // captains
    Route::get('new-captains',         [CaptainController::class, 'getNewCaptains']);
    Route::get('approved-captains',    [CaptainController::class, 'getApprovedCaptains']);
    Route::get('captains/{id}',        [CaptainController::class, 'getCaptain']);
    Route::post('approve-captain/{id}',[CaptainController::class, 'approve']);
    Route::delete('captains/{id}',     [CaptainController::class, 'delete']);
});