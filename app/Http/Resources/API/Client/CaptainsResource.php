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
            'bio' => $this->info->bio,
            'vehicle_title' => $this->info->vehicle_title,
            'vehicle_model' => $this->info->vehicle_model,
            'vehicle_plate' => $this->info->vehicle_plate,
            'vehicle_type' => $this->info->vehicle_type,
            'completed_reservations_count' => $this->reservations->where('status', ReservationStatus::COMPLETED->value)->count(),
            'car_image_url' => $this->info?->getFirstMediaUrl('car_image'),
            'personal_image_url' => $this->info->getFirstMediaUrl('personal_image'),
        ];
    }
}
