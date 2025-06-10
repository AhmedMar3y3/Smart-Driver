<?php

namespace App\Http\Requests\API\Client\Password;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ResetPasswordSendCodeRequest extends BaseRequest
{
   public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('clients', 'email'),
            ]
        ];
    }
}
