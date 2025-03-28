<?php

namespace App\Http\Requests\API\Client\Client;

use App\Http\Requests\BaseRequest;
class LoginClientRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:clients,email',
            'password' => 'required',
        ];
    }
}
