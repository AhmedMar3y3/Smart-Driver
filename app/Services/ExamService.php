<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\QuestionSubscription;
use Carbon\Carbon;

class ExamService
{
    public function startExam($client, $subscriptionId)
    {
        $subscription = QuestionSubscription::where('id', $subscriptionId)
            ->where('client_id', $client->id)
            ->where('status', 'active')
            ->firstOrFail();

        $exam = Exam::create([
            'question_subscription_id' => $subscription->id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addMinutes($subscription->package->time_limit),
            'status' => 'in_progress',
        ]);

        return $exam;
    }

    public function submitExam($client, $examId, $answers)
    {
        $exam = Exam::where('id', $examId)
            ->whereHas('subscription', fn($q) => $q->where('client_id', $client->id))
            ->firstOrFail();

        if ($exam->status !== 'in_progress') {
            throw new \Exception('Exam is not in progress.');
        }

        foreach ($answers as $answer) {
            $exam->answers()->create([
                'question_id' => $answer['question_id'],
                'choice_id' => $answer['choice_id'],
            ]);
        }

        $correctAnswers = $exam->answers()->whereHas('choice', fn($q) => $q->where('is_correct', true))->count();
        $totalQuestions = $exam->subscription->package->questions()->count();
        $score = ($correctAnswers / $totalQuestions) * 100;

        $exam->update([
            'status' => 'completed',
            'score' => $score,
            'end_time' => Carbon::now(),
        ]);

        if ($score >= 90) {
            $exam->subscription->update(['status' => 'completed']);
        }

        return ['score' => $score, 'passed' => $score >= 90];
    }
}