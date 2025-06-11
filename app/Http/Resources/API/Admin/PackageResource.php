<?php

namespace App\Http\Resources\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'price' => $this->price,
            'type' => $this->type,
            'title_ar' => $this->getTranslation('ar')->title ?? null,
            'title_en' => $this->getTranslation('en')->title ?? null,
            'title_ur' => $this->getTranslation('ur')->title ?? null,
            'description_ar' => $this->getTranslation('ar')->description ?? null,
            'description_en' => $this->getTranslation('en')->description ?? null,
            'description_ur' => $this->getTranslation('ur')->description ?? null,
        ];
    }
}
