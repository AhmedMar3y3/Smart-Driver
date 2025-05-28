<?php

namespace App\Http\Resources\API\Client\Exam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmitAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isLastQuestion = !isset($this['question']);
        return [
            'id' => (int)$request->input('exam_id'),
            'total_questions' => $this['total_questions'] ?? null,
            'remaining_time' => $this['remaining_time'] ?? null,
            'question' => $isLastQuestion ? null : new QuestionResource($this['question']),
            'message' => $isLastQuestion ? $this['message'] : null,
        ];
    }
}
