<?php

namespace App\Http\Requests\API\Client\Car;

use App\Http\Requests\BaseRequest;

class FilterCarsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0',
            'brand_id' => 'nullable|exists:brands,id',
            'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_to' => 'nullable|integer|min:1900|max:' . date('Y'),
            'type' => 'nullable|in:0,1',
        ];
    }
}
