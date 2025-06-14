<?php

namespace App\Http\Requests\API\Admin\Hero;

use App\Http\Requests\BaseRequest;
class UpdateHeroRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_ur' => 'nullable|string|max:255',
            'image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:10248',
        ];
    }
}
