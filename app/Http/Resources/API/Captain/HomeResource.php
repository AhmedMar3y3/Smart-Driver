<?php

namespace App\Http\Resources\API\Captain;

use Illuminate\Http\Request;
use App\Enums\ReservationStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pending' => $this->reservations()->where('status', ReservationStatus::PENDING->value )->count(),
            'reserved' => $this->reservations()->where('status', ReservationStatus::CONFIRMED->value )->count(),
            'completed' => $this->reservations()->where('status', ReservationStatus::COMPLETED->value )->count(),
        ];
    }
}
