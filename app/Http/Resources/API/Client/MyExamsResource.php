<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyExamsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'subscription_id' => $this->id,
            'subscription_status' => $this->status,
            'package_id' => $this->package->id,
            'package_title' => $this->package->title,
            'package_price' => $this->package->price,
            'package_time_limit' => $this->package->time_limit,
            'package_questions_count' => $this->package->questions->count(),
        ];
    }
}
