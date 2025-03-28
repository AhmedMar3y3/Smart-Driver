<?php

namespace App\Http\Requests\API\Client\Plate;

use App\Http\Requests\BaseRequest;

class StorePlateRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number'     => 'required|string|unique:plates,number|regex:/^\d{1,6}$/',
            'price'      => 'nullable|numeric',
            'phone'      => 'required|string',
            'address'    => 'nullable|string',
            'emirate_id' => 'required|exists:emirates,id',
        ];
    }
}
