<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedCaptainResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'is_approved' => $this->is_approved,
            'completed_info' => $this->completed_info,
            'rating' => $this->rating,
            'views_count' => $this->views_count,
            'info' => [
                'id' => $this->info->id,
                'captain_id' => $this->info->captain_id,
                'has_car' => $this->info->has_car,
                'name' => $this->info->name,
                'email' => $this->info->email,
                'phone' => $this->info->phone,
                'ID_card' => $this->info->ID_card,
                'country' => $this->info->country,
                'address' => $this->info->address,
                'bio' => $this->info->bio,
                'driving_license' => $this->info->driving_license,
                'issued_by' => $this->info->issued_by,
                'issued_at' => $this->info->issued_at,
                'expires_at' => $this->info->expires_at,
                'vehicle_title' => $this->info->vehicle_title,
                'vehicle_model' => $this->info->vehicle_model,
                'vehicle_plate' => $this->info->vehicle_plate,
                'vehicle_type' => $this->info->vehicle_type,
                'personal_image_url' => $this->info?->getFirstMediaUrl('personal_image'),
                'car_image_url' => $this->info?->getFirstMediaUrl('car_image'),
                'license_image_url' => $this->info?->getFirstMediaUrl('license_image'),
                'residence_image_url' => $this->info?->getFirstMediaUrl('residence_image'),
            ],
        ];
    }
}