<?php

namespace App\Http\Controllers\API\Client;

use App\Models\Hero;
use App\Models\Package;
use App\Enums\PackageType;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\CarPackageResource;
use App\Http\Resources\API\Client\PlatePackageResource;

class HomeController extends Controller
{
    use HttpResponses;
    public function getHero()
    {
        $hero = Hero::get(['id', 'title', 'image']);
        return $this->successWithDataResponse($hero);
    }

    public function carPackages()
    {
        $packages = Package::where('type', PackageType::CAR->value)->get();
        return $this->successWithDataResponse(CarPackageResource::collection($packages));
    }

    public function platePackages()
    {
        $packages = Package::where('type', PackageType::PLATE->value)->get();
        return $this->successWithDataResponse(PlatePackageResource::collection($packages));
    }
}
