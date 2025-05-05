<?php

namespace App\Http\Controllers\API\Captain;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\ReviewsResource;

class ReviewController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $captain = auth('captain')->user();
        $reviews = $captain->reviews()->paginate(10);
        return $this->successWithDataResponse(ReviewsResource::collection($reviews));
    }
}
