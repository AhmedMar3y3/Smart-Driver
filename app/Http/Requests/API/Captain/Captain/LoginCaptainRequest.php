<?php

namespace App\Http\Requests\API\Captain\Captain;

use Illuminate\Foundation\Http\FormRequest;

class LoginCaptainRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
} 