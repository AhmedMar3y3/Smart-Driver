<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilitiesResource extends JsonResource
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
            'date' => $this->date->translatedFormat('d F Y'),
            'day' => $this->date->translatedFormat('l'),
            'from' => $this->from,
            'to' => $this->to,
        ];
    }
}
