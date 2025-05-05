<?php

namespace App\Http\Requests\API\Client\Review;

use App\Http\Requests\BaseRequest;

class PostReviewRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'captain_id' => 'required|exists:captains,id',
            'review' => 'required|string|max:255',
            'rating' => 'required|integer|in:1,2,3,4,5',
        ];
    }
}
