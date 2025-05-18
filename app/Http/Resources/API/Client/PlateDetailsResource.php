<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlateDetailsResource extends JsonResource
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
            'number' => $this->number,
            'price' => $this->price ?? 'الرجاء التواصل مع المعلن لمعرفة السعر',
            'emirate_id' => $this->emirate_id,
            'emirate' => $this->emirate->name,
            'created_at' => $this->created_at->format('Y-m-d'),
            'client_phone' => $this->client->phone,
            'client_name' => $this->client->name,
            'client_email' => $this->client->email,
            'client_image' => $this->client->image ? url($this->client->image) : null,
            'type' => $this->type,
            'code' => $this->plateCode->code ? $this->plateCode->code : null,
        ];
    }
}
