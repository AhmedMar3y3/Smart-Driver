<?php

namespace App\Http\Requests\API\Admin\Package;

use App\Http\Requests\BaseRequest;

class UpdatePackageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'type' => 'nullable|in:car,plate,captain',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'required_if:type,plate,captain|integer|min:1|nullable',
            'ad_duration' => 'required_if:type,car|integer|min:1|nullable',
            'allowed_ads' => 'required_if:type,plate|integer|min:0|nullable',
            'allowed_ads_per_month' => 'required_if:type,car|integer|min:0|nullable',
            'title_en' => 'nullable|string',
            'title_ar' => 'nullable|string',
            'title_ur' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_ur' => 'nullable|string',
        ];
    }
}
