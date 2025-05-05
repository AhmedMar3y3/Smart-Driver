<?php

namespace App\Http\Controllers\API\Client;

use App\Traits\HttpResponses;
use App\Models\CaptainReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\Review\PostReviewRequest;

class ReviewController extends Controller
{
    use HttpResponses;
    public function postReview(PostReviewRequest $request)
    {
        CaptainReview::create($request->validated() + ['client_id' => auth('client')->user()->id]);
        return $this->successResponse('تم إضافة المراجعة بنجاح');
    }
}
