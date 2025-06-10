<?php

namespace App\Http\Requests\API\Client\Password;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ResetPasswordCheckCodeRequest extends BaseRequest
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
            ]
        ];
    }
}
