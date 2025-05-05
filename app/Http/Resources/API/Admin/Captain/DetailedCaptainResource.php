<?php

namespace App\Http\Resources\API\Admin\Captain;

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
            'is_subscribed' => $this->is_subscribed,
            'info_id' => $this->info->id,
            'info' => [
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
                'personal_image' => $this->info->getFirstMediaUrl('personal_image'),
                'car_image' => $this->info->getFirstMediaUrl('car_image') ?? null,
                'license_image' => $this->info->getFirstMediaUrl('license_image'),
                'residence_image' => $this->info->getFirstMediaUrl('residence_image'),
            ],
        ];
    }
}