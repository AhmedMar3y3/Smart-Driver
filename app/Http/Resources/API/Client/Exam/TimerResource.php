<?php

namespace App\Http\Resources\API\Client\Exam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'exam_id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'package_limit' => $this->subscription->package->time_limit,
            'total_questions' => $this->subscription->package->questions->count(),
        ];
    }
}
