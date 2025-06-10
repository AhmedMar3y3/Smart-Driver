<?php

namespace App\Http\Requests\API\Captain\Password;


use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'code'      => [
                'required',
                'numeric',
            ],
            'email'     => [
                'required',
                'email',
                Rule::exists('captains', column: 'email'),
            ],
            'password'  => [
                'required',
                'string',
                'confirmed',
            ],
        ];
    }
}
