<?php

namespace App\Http\Resources\API\Client;

use App\Enums\ReservationStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaptainsResource extends JsonResource
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
            'name' => $this->name,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews->count(),
            'completed_reservations_count' => $this->reservations->where('status', ReservationStatus::COMPLETED->value)->count(),
            'personal_image_url' => $this->info->getFirstMediaUrl('personal_image'),
        ];
    }
}
