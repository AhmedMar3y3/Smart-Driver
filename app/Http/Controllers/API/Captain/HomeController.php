<?php

namespace App\Http\Controllers\API\Captain;

use App\Enums\PackageType;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\HomeResource;
use App\Http\Resources\API\Captain\PackagesResource;
use App\Models\Package;

class HomeController extends Controller
{
    use HttpResponses;

    public function stats()
    {
        $captain = auth('captain')->user();
        return $this->successWithDataResponse(HomeResource::make($captain));
    }

    public function packages()
    {
        $packages = Package::where('type', PackageType::CAPTAIN->value)->get();
        return $this->successWithDataResponse(PackagesResource::collection($packages));
    }
    
}
