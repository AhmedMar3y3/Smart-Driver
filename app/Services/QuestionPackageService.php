<?php

namespace App\Services;

use App\Models\QuestionPackage;
use Illuminate\Support\Facades\DB;

class QuestionPackageService
{

    public function getAllPackages()
    {
        return QuestionPackage::all();
    }

    public function getPackageById($id)
    {
        return QuestionPackage::findOrFail($id);
    }
    public function createPackage(array $data)
    {
        return DB::transaction(function () use ($data) {
            $package = QuestionPackage::create([
                'level_order' => $data['level_order'],
                'price' => $data['price'],
                'time_limit' => $data['time_limit'],
            ]);

            foreach (['en', 'ar', 'ur'] as $locale) {
                $package->translateOrNew($locale)->title = $data["title_{$locale}"];
                $package->translateOrNew($locale)->description = $data["description_{$locale}"];
            }
            $package->save();

            foreach ($data['questions'] as $questionData) {
                $question = $package->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'image' => $questionData['image'] ?? null,
                ]);

                foreach ($questionData['choices'] as $choiceData) {
                    $question->choices()->create([
                        'choice_text' => $choiceData['choice_text'],
                        'image' => $choiceData['image'] ?? null,
                        'is_correct' => $choiceData['is_correct'],
                    ]);
                }
            }

            return $package;
        });
    }

    public function deletePackage($id)
    {
        $package = QuestionPackage::findOrFail($id);
        $package->delete();
    }
}