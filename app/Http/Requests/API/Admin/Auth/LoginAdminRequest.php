<?php

namespace App\Http\Requests\API\Admin\Auth;

use App\Http\Requests\BaseRequest;

class LoginAdminRequest extends BaseRequest
{
   
    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];
    }
}
