<?php

namespace App\Http\Requests\API\Captain\Availability;

use App\Http\Requests\BaseRequest;

class StoreAvailabilityRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d',
            'from' => 'required|date_format:H:i',
            'to'   => 'required|date_format:H:i|after:from',
        ];
    }
}
