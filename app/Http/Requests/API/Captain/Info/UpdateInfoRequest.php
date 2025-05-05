<?php

namespace App\Http\Requests\API\Captain\Info;

use App\Http\Requests\BaseRequest;

class UpdateInfoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'bio'   => 'nullable|string',
        ];
    }
}