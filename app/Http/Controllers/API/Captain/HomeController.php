<?php

namespace App\Http\Controllers\API\Captain;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\HomeResource;

class HomeController extends Controller
{
    use HttpResponses;

    public function stats()
    {
        $captain = auth('captain')->user();
        return $this->successWithDataResponse(HomeResource::make($captain));
    }
    
}
