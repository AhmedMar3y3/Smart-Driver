<?php

namespace App\Http\Resources\API\Client\Exam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'type' => $this->type,
            'text' => $this->question_text,
            'image' => $this->image,
            'choices' => ChoiceResource::collection($this->choices),
        ];
    }
}
