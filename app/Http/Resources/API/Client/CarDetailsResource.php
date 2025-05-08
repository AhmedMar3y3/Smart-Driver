<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailsResource extends JsonResource
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
            'category' => $this->category->name,
            'price' => $this->price,
            'year' => $this->year,
            'distance' => $this->distance,
            'type' => $this->type->formattedName(),
            'created_from' => $this->created_at->diffForHumans(),
            'additional_info' => $this->additional_info,
            'brand_id' => $this->brand_id,
            'brand' => $this->brand->name,
            'images' => $this->images->pluck('image')->map(function ($image) {
                return url($image);
            }),
            'client_name' => $this->client->name,
            'client_phone' => $this->client->phone,
            'client_email' => $this->client->email,
            'client_image' => $this->client->image ? url($this->client->image) : null,

        ];
    }
}
