<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('accept-language', 'en');
        $titleKey = match (strtolower($lang)) {
            'ar' => 'title_ar',
            'ur' => 'title_ur',
            default => 'title_en',
        };

        return [
            'id' => $this->id,
            'title' => $this->{$titleKey},
            'image' => $this->image,
        ];
    }
}
