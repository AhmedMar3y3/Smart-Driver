<?php

namespace App\Http\Requests\API\Client\Reservation;

use App\Http\Requests\BaseRequest;

class ReserveCaptainRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|string',
            'availability_id' => 'required|exists:captain_availabilities,id',
        ];
    }
}
