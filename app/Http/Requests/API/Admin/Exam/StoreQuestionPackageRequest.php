<?php

namespace App\Http\Requests\API\Admin\Exam;

use App\Http\Requests\BaseRequest;

class StoreQuestionPackageRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'level_order' => 'required|integer|unique:question_packages,level_order',
            'price' => 'required|numeric|min:0',
            'time_limit' => 'required|integer|min:1',
            'title_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'title_ar' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'title_ur' => 'required|string|max:255',
            'description_ur' => 'nullable|string',
            'questions' => 'required|array',
            'questions.*.type' => 'required|string|in:text,image,text_with_image',
            'questions.*.question_text' => [
            'required_if:questions.*.type,text,questions.*.type,text_with_image',
            'nullable',
            'string',
            ],
            'questions.*.image' => [
            'required_if:questions.*.type,image,questions.*.type,text_with_image',
            'nullable',
            'image',
            'mimes:jpeg,png,jpg,gif',
            'max:2048',
            ],
            'questions.*.choices' => [
            'required',
            'array',
            'size:4',
            function ($attribute, $value, $fail) {
                $correctCount = collect($value)->where('is_correct', true)->count();
                if ($correctCount !== 1) {
                $fail("Each question must have exactly one correct choice.");
                }
            },
            ],
            'questions.*.choices.*.type' => 'required|string|in:text,image,text_with_image',
            'questions.*.choices.*.choice_text' => [
            'required_if:questions.*.choices.*.type,text,questions.*.choices.*.type,text_with_image',
            'nullable',
            'string',
            ],
            'questions.*.choices.*.image' => [
            'required_if:questions.*.choices.*.type,image,questions.*.choices.*.type,text_with_image',
            'nullable',
            'image',
            'mimes:jpeg,png,jpg,gif',
            'max:2048',
            ],
            'questions.*.choices.*.is_correct' => 'required|boolean',
        ];
    }
}