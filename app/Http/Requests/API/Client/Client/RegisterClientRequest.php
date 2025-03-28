<?php

namespace App\Http\Requests\API\Client\Client;

use App\Http\Requests\BaseRequest;

class RegisterClientRequest extends BaseRequest
{

    /**
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:clients,email',
            'phone' => 'required|string',
            'password' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
