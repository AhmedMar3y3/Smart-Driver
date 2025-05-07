<?php

namespace App\Http\Controllers\API\Captain;

use App\Models\Package;
use App\Enums\PackageType;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\PackagesResource;
class PackageController extends Controller
{
    use HttpResponses;

    public function captainPackages()
    {
        $packages = Package::where('type', PackageType::CAPTAIN->value)->get();
        return $this->successWithDataResponse(PackagesResource::collection($packages));
    }
}
