<?php

namespace App\Http\Requests\API\Client;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
                'min:8',
            ],
        ];
    }
}
