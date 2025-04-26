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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:captains',
            'password' => 'required|string|min:8',
        ];
    }
} 