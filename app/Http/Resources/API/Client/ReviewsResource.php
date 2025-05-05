<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
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
            'client' => [
                'name' => $this->client->name,
                'image' => $this->client->image,
            ],
            'review' => $this->review,
            'rating' => $this->rating,
            'created_at' => $this->created_at->format('d F Y'),
            'created_at_ar' => $this->created_at->translatedFormat('d F Y'),
        ];
    }
}
