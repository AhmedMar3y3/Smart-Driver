<?php

namespace App\Http\Requests\API\Client\Plate;

use App\Http\Requests\BaseRequest;
class FilterPlateRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'emirate_id' => 'sometimes|exists:emirates,id',
            // 'price_from' => 'sometimes|numeric|min:0',
            // 'price_to' => 'sometimes|numeric|min:0',
        ];
    }
}
