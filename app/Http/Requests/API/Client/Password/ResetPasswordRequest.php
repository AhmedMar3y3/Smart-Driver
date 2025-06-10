<?php

namespace App\Http\Requests\API\Client\Password;


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
                Rule::exists('clients', 'email'),
            ],
            'password'  => [
                'required',
                'string',
                'confirmed',
            ],
        ];
    }
}
