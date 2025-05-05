<?php

namespace App\Http\Requests\API\Captain\Info;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                 'string'
                ],
            'password'     => [
                'required',
                'string',
                'confirmed'
            ],
        ];
    }
}
