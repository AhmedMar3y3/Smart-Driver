<?php

namespace App\Http\Requests\API\Admin\Section;

use App\Http\Requests\BaseRequest;

class UpdateSectionRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:10248',
        ];
    }
}
