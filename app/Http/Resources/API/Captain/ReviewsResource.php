<?php

namespace App\Http\Resources\API\Captain;

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
        ];
    }
}
