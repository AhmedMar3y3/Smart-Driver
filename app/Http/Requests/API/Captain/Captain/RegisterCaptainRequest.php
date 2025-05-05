<?php

namespace App\Http\Requests\API\Captain\Captain;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCaptainRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:captains',
            'phone' => 'required|string|unique:captains',
            'password' => 'required|string',
        ];
    }
} 