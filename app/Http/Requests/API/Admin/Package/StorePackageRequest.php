<?php

namespace App\Http\Requests\API\Admin\Package;

use App\Http\Requests\BaseRequest;

class StorePackageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|in:car,plate,captain',
            'price' => 'required|numeric|min:0',
            'duration' => 'required_if:type,plate,captain|integer|min:1|nullable',
            'ad_duration' => 'required_if:type,car|integer|min:1|nullable',
            'allowed_ads' => 'required_if:type,plate|integer|min:0|nullable',
            'allowed_ads_per_month' => 'required_if:type,car|integer|min:0|nullable',
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'title_ur' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_ur' => 'nullable|string',
        ];
    }
}
