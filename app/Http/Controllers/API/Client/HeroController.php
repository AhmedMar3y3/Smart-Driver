<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Hero\StoreHeroRequest;
use App\Http\Requests\API\Admin\Hero\UpdateHeroRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Hero;

class HeroController extends Controller
{
    use HttpResponses;
    public function getHero()
    {
        $hero = Hero::get(['id', 'title', 'image']);
        return $this->successWithDataResponse($hero);
    }
}
