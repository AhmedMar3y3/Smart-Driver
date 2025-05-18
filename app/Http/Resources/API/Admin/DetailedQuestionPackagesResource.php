<?php

namespace App\Http\Resources\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedQuestionPackagesResource extends JsonResource
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
            'title_en' => $this->getTranslation('en')->title,
            'title_ar' => $this->getTranslation('ar')->title,
            'title_ur' => $this->getTranslation('ur')->title,
            'description_en' => $this->getTranslation('en')->description,
            'description_ar' => $this->getTranslation('ar')->description,
            'description_ur' => $this->getTranslation('ur')->description,
            'price' => $this->price,
            'time_limit' => $this->time_limit,
            'level_order' => $this->level_order,
            'questions' => $this->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'image' => $question->image,
                    'choices' => $question->choices->map(function ($choice) {
                        return [
                            'id' => $choice->id,
                            'choice_text' => $choice->choice_text,
                            'image' => $choice->image,
                            'is_correct' => $choice->is_correct,
                        ];
                    }),
                ];
            }),
        ];
    }
}
