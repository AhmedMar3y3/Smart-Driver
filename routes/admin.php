<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\CarController;
use App\Http\Controllers\API\Admin\HeroController;
use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\PlateController;
use App\Http\Controllers\API\Admin\BrandsController;
use App\Http\Controllers\API\Admin\PackageController;
use App\Http\Controllers\API\Admin\CaptainController;
use App\Http\Controllers\API\Admin\SectionsController;
use App\Http\Controllers\API\Admin\QuestionPackageController;

Route::post('register',[AuthController::class, 'register']);
Route::post('login',   [AuthController::class, 'login']);

Route::middleware(['auth.admin', 'set-locale'])->group(function () {
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

    // packages
    Route::get('packages',             [PackageController::class, 'index']);
    Route::get('packages/{package}',   [PackageController::class, 'show']);
    Route::post('packages',            [PackageController::class, 'store']);
    Route::post('packages/{package}',  [PackageController::class, 'update']);
    Route::delete('packages/{package}',[PackageController::class, 'destroy']);

    // question packages
    Route::get('question-packages',        [QuestionPackageController::class, 'index']);
    Route::get('question-packages/{id}',   [QuestionPackageController::class, 'show']);
    Route::post('question-packages',       [QuestionPackageController::class, 'store']);
    Route::delete('question-packages/{id}',[QuestionPackageController::class, 'destroy']);

    // section routes
    Route::get('sections',      [SectionsController::class, 'index']);
    Route::get('sections/{id}', [SectionsController::class, 'show']);
    Route::post('sections/{id}',[SectionsController::class, 'update']);

});