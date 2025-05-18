<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyAttemptsResource extends JsonResource
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
            'package_title' => $this->subscription->package->title,
            'score' => $this->score,
            'status' => $this->subscription->status,
            'date' => $this->created_at->translatedFormat('d F Y'),
        ];
    }
}
