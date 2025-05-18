<?php

namespace App\Http\Requests\API\Client\Client;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class VerifyClientRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                Rule::exists('clients', 'email'),
            ],
            'code' => ['required', 'numeric'],
        ];
    }
}
