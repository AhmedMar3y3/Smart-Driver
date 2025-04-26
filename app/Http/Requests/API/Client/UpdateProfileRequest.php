<?php

namespace App\Http\Requests\API\Client;

use App\Http\Requests\BaseRequest;

class UpdateProfileRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ];
    }
}
