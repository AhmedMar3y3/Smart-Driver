<?php

namespace App\Http\Resources\API\Captain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoResource extends JsonResource
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
            'ID_card' => $this->ID_card,
            'country' => $this->country,
            'address' => $this->address,
            'bio' => $this->bio,
            'driving_license' => $this->driving_license,
            'issued_by' => $this->issued_by,
            'issued_at' => $this->issued_at,
            'expires_at' => $this->expires_at,
            'has_car' => $this->has_car,
            'vehicle_title' => $this->vehicle_title,
            'vehicle_model' => $this->vehicle_model,
            'vehicle_plate' => $this->vehicle_plate,
            'vehicle_type' => $this->vehicle_type,
            'personal_image_url' => $this->getFirstMediaUrl('personal_image'),
            'car_image_url' => $this->getFirstMediaUrl('car_image'),
            'license_image_url' => $this->getFirstMediaUrl('license_image'),
            'residence_image_url' => $this->getFirstMediaUrl('residence_image'),
        ];
    }
}
