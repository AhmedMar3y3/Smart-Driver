<?php

namespace App\Http\Resources\API\Client\Exam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamStartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'subscription_id' => $this->question_subscription_id,
            'total_questions' => $this->subscription->package->questions->count(),
            // 'start_time' => $this->start_time,
            // 'end_time' => $this->end_time,
            // 'status' => $this->status,
            'question' => new QuestionResource($this->subscription->package->questions->first()),
        ];
    }
}
