<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\Exam\ExamStartResource;
use App\Http\Resources\API\Client\Exam\SubmitAnswerResource;
use App\Http\Resources\API\Client\Exam\TimerResource;
use App\Models\Exam;
use App\Services\ExamService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    use HttpResponses;
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function startExam(Request $request)
    {
        $client = auth('client')->user();
        $exam = $this->examService->startExam($client, $request->input('subscription_id'));
        return $this->successWithDataResponse(new ExamStartResource($exam));
    }

    public function getQuestion($examId, $questionOrder)
    {
        $client = auth('client')->user();
        $questionData = $this->examService->getQuestion($client, $examId, $questionOrder);
        return $this->successWithDataResponse($questionData);
    }

    public function submitAnswer(Request $request)
    {
        $client = auth('client')->user();
        $examId = $request->input('exam_id');
        $questionId = $request->input('question_id');
        $choiceId = $request->input('choice_id');
        $result = $this->examService->submitAnswer($client, $examId, $questionId, $choiceId);
        return $this->successWithDataResponse(new SubmitAnswerResource($result));
    }

    public function submitExam(Request $request)
    {
        $client = auth('client')->user();
        $examId = $request->input('exam_id');
        $result = $this->examService->submitExam($client, $examId);
        return $this->successWithDataResponse($result);
    }

    public function timer($examId)
    {
        $client = auth('client')->user();
        $timerData = Exam::where('id', $examId)
            ->whereHas('subscription', function ($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->first();
        return $this->successWithDataResponse(new TimerResource($timerData));
    }
}