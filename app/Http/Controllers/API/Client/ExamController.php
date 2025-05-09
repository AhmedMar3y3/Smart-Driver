<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function startExam(Request $request)
    {
        $client = auth('client')->user();
        $exam = $this->examService->startExam($client, $request->input('subscription_id'));
        return response()->json(['message' => 'Exam started', 'data' => $exam], 200);
    }

    public function submitExam(Request $request)
    {
        $client = auth('client')->user();
        $result = $this->examService->submitExam($client, $request->input('exam_id'), $request->input('answers'));
        return response()->json(['message' => 'Exam submitted', 'data' => $result], 200);
    }
}