<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Emirate;
use App\Traits\HttpResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HttpResponses;

    public function emirates()
    {
        $emirates = Emirate::get(['id', 'name']);
        return $this->successWithDataResponse($emirates);
    }
    public function brands()
    {
        $brands = Brand::get(['id', 'name', 'logo']);
        return $this->successWithDataResponse($brands);
    }
}
