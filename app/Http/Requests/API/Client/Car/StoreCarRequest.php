<?php

namespace App\Http\Requests\API\Client\Car;

use App\Http\Requests\BaseRequest;

class StoreCarRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => 'required|string',
            'brand_id'        => 'required|integer|exists:brands,id',
            'category'        => 'required|string',
            'year'            => 'required|integer|before_or_equal:'.date('Y'),
            'distance'        => 'required|integer',
            'color'           => 'required|string',
            'price'           => 'required|numeric',
            'type'            => 'required|numeric|in:0,1',
            'additional_info' => 'nullable|string',
            'phone'           => 'required|string',
            'address'         => 'required|string',
            'images'          => 'required|array',
            'images.*'        => 'required|image|mimes:png,jpg,jpeg',
        ];
    }
}
