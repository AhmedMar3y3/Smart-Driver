<?php

namespace App\Http\Requests\API\Captain\Availability;

use App\Http\Requests\BaseRequest;

class UpdateAvailabilityRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'date' => 'nullable|date_format:Y-m-d',
            'from' => 'nullable|date_format:H:i',
            'to'   => 'nullable|date_format:H:i|after:from',
        ];
    }
}
