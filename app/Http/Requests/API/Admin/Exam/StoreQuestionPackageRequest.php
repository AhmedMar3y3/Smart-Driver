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
            'questions.*.question_text' => 'required|string',
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'questions.*.choices.*.choice_text' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $index = str_replace(['questions.', '.choices.*.choice_text'], '', $attribute);
                    $choiceImage = request()->input("questions.$index.choices.*.image");
                    if (empty($value) && empty($choiceImage)) {
                        $fail("Each choice must have either text or an image.");
                    }
                    if (!empty($value) && !empty($choiceImage)) {
                        $fail("Each choice can only have either text or an image, not both.");
                    }
                },
            ],
            'questions.*.choices.*.image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) {
                    $index = str_replace(['questions.', '.choices.*.image'], '', $attribute);
                    $choiceText = request()->input("questions.$index.choices.*.choice_text");
                    if (empty($value) && empty($choiceText)) {
                        $fail("Each choice must have either text or an image.");
                    }
                    if (!empty($value) && !empty($choiceText)) {
                        $fail("Each choice can only have either text or an image, not both.");
                    }
                },
            ],
            'questions.*.choices.*.is_correct' => 'required|boolean',
        ];
    }
}