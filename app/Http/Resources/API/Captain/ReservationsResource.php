<?php

namespace App\Http\Resources\API\Captain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationsResource extends JsonResource
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
            'phone' => $this->phone,
            'date' => $this->availability->date->translatedFormat('d F Y'),
            'day' => $this->availability->date->translatedFormat('l'),
            'from' => $this->availability->from,
            'to' => $this->availability->to,
            'status' => $this->status,
        ];
    }
}
