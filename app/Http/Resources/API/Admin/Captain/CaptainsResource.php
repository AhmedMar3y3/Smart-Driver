<?php

namespace App\Http\Resources\API\Admin\Captain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaptainsResource extends JsonResource
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
            'is_subscribed' => $this->isSubscribed(),
            'completed_info' => $this->completed_info,
        ];
    }
}
