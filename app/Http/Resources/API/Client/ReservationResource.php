<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'captain' => $this->captain->name,
            'personal_image_url' => $this->captain->info->getFirstMediaUrl('personal_image'),
            'from' => $this->availability->from,
            'to' => $this->availability->to,
            'date' => $this->availability->date->translatedFormat('d F Y'),
            'day' => $this->availability->date->translatedFormat('l'),
            'status' => $this->status,
        ];
    }
}
