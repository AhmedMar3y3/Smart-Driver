<?php

namespace App\Http\Requests\API\Admin\Auth;

use App\Http\Requests\BaseRequest;

class RegisterAdminRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string',
        ];
    }
}
