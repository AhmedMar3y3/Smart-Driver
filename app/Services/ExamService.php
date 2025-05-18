<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Exam;
use App\Models\QuestionSubscription;
use App\Models\QuestionPackage;
use Carbon\Carbon;

class ExamService
{
    public function startExam($client, $subscriptionId)
    {
        $subscription = QuestionSubscription::where('id', $subscriptionId)
            ->where('client_id', $client->id)
            ->where('status', 'active')
            ->first();
        if (!$subscription) {
            throw new CustomException('Subscription not found or not active.');
        }

        $package = $subscription->package;
        $previousPackages = QuestionPackage::where('level_order', '<', $package->level_order)->get();
        foreach ($previousPackages as $prevPackage) {
            $prevSubscription = $client->questionSubscriptions()
                ->where('question_package_id', $prevPackage->id)
                ->where('status', 'completed')
                ->first();
            if (!$prevSubscription) {
                throw new CustomException('You must pass all previous levels first.');
            }
        }

        if ($subscription->exams()->exists()) {
            throw new CustomException('An exam has already been taken for this subscription.');
        }

        $exam = Exam::create([
            'question_subscription_id' => $subscription->id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addMinutes($subscription->package->time_limit),
            'status' => 'in_progress',
        ]);

        return $exam;
    }

    public function getQuestion($client, $examId, $questionOrder)
    {
        $exam = Exam::where('id', $examId)
            ->whereHas('subscription', fn($q) => $q->where('client_id', $client->id))
            ->firstOrFail();

        if ($exam->status !== 'in_progress') {
            throw new CustomException('The exam is not in progress.');
        }

        if (Carbon::now()->greaterThan($exam->end_time)) {
            $this->autoSubmitExam($exam);
            throw new CustomException('The exam time has expired and it has been submitted automatically.');
        }

        $package = $exam->subscription->package;
        $questions = $package->questions()->orderBy('id')->get();

        if ($questionOrder < 1 || $questionOrder > $questions->count()) {
            throw new CustomException('Invalid question order.');
        }

        $question = $questions[$questionOrder - 1];
        $answer = $exam->answers()->where('question_id', $question->id)->first();
        $selectedChoiceId = $answer ? $answer->choice_id : null;

        return [
            'question' => $question,
            'choices' => $question->choices,
            'selected_choice_id' => $selectedChoiceId,
            'order' => $questionOrder,
            'total_questions' => $questions->count(),
            'remaining_time' => $exam->end_time->diffInSeconds(Carbon::now()),
        ];
    }

    public function submitAnswer($client, $examId, $questionId, $choiceId)
    {
        $exam = Exam::where('id', $examId)
            ->whereHas('subscription', fn($q) => $q->where('client_id', $client->id))
            ->firstOrFail();

        if ($exam->status !== 'in_progress') {
            throw new CustomException('The exam is not in progress.');
        }

        if (Carbon::now()->greaterThan($exam->end_time)) {
            $this->autoSubmitExam($exam);
            throw new CustomException('The exam time has expired and it has been submitted automatically.');
        }

        $question = $exam->subscription->package->questions()->findOrFail($questionId);
        if ($exam->answers()->where('question_id', $questionId)->exists()) {
            throw new CustomException('You have already answered this question.');
        }

        $choice = $question->choices()->findOrFail($choiceId);

        $exam->answers()->create([
            'question_id' => $questionId,
            'choice_id' => $choiceId,
        ]);

        $nextOrder = $question->id === $exam->subscription->package->questions()->orderBy('id')->get()->last()->id
            ? null
            : $exam->answers()->count() + 1;

        return $nextOrder ? $this->getQuestion($client, $examId, $nextOrder) : ['message' => 'All questions answered'];
    }

    public function submitExam($client, $examId)
    {
        $exam = Exam::where('id', $examId)
            ->whereHas('subscription', fn($q) => $q->where('client_id', $client->id))
            ->firstOrFail();

        if ($exam->status !== 'in_progress') {
            throw new CustomException('The exam is not in progress.');
        }

        $now = Carbon::now();
        $totalQuestions = $exam->subscription->package->questions()->count();
        $answeredQuestions = $exam->answers()->count();

        if ($answeredQuestions < $totalQuestions && $now <= $exam->end_time) {
            throw new CustomException('You must answer all questions before submitting.');
        }

        $correctAnswers = $exam->answers()->whereHas('choice', fn($q) => $q->where('is_correct', true))->count();
        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        $exam->update([
            'status' => 'completed',
            'score' => $score,
            'end_time' => $now,
        ]);

        $subscriptionStatus = $score >= 90 ? 'completed' : 'failed';
        $exam->subscription->update(['status' => $subscriptionStatus]);

        return ['score' => $score, 'passed' => $score >= 90];
    }

    protected function autoSubmitExam($exam)
    {
        $correctAnswers = $exam->answers()->whereHas('choice', fn($q) => $q->where('is_correct', true))->count();
        $totalQuestions = $exam->subscription->package->questions()->count();
        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        $exam->update([
            'status' => 'completed',
            'score' => $score,
            'end_time' => Carbon::now(),
        ]);

        $subscriptionStatus = $score >= 90 ? 'completed' : 'failed';
        $exam->subscription->update(['status' => $subscriptionStatus]);
    }
}
