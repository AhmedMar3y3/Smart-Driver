<?php

namespace App\Http\Resources\API\Captain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
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
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
        ];
    }
}
