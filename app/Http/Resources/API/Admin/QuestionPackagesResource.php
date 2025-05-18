<?php

namespace App\Http\Resources\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionPackagesResource extends JsonResource
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
            'price' => $this->price,
            'time_limit' => $this->time_limit,
            'level_order' => $this->level_order,
        ];
    }
}
