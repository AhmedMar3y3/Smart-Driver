<?php

namespace App\Http\Requests\API\Captain\Info;

use App\Http\Requests\BaseRequest;

class CompleteInfoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'has_car' => 'required|boolean',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'ID_card' => 'required|string',
            'country' => 'required|string',
            'address' => 'required|string',
            'bio' => 'nullable|string',
            'driving_license' => 'nullable|string',
            'issued_by' => 'nullable|string',
            'issued_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'personal_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'car_image' => 'required_if:has_car,true|prohibited_if:has_car,false|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'license_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'residence_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_title' => 'required_if:has_car,true|prohibited_if:has_car,false|nullable|string',
            'vehicle_model' => 'required_if:has_car,true|prohibited_if:has_car,false|nullable|string',
            'vehicle_plate' => 'required_if:has_car,true|prohibited_if:has_car,false|nullable|string',
            'vehicle_type' => 'required_if:has_car,true|prohibited_if:has_car,false|nullable|string',
        ];
    }
}