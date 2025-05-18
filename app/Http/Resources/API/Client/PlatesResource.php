<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatesResource extends JsonResource
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
            'type' => $this->type,
            'code' => $this->plateCode->code ?? null,
        ];
    }
}
