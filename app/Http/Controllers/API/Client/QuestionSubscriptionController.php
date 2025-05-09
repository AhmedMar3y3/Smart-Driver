<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Services\QuestionSubscriptionService;
use Illuminate\Http\Request;

class QuestionSubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(QuestionSubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        $client = auth('client')->user();
        $subscription = $this->subscriptionService->subscribe($client, $request->input('package_id'));
        return response()->json(['message' => 'Subscription initiated', 'data' => $subscription], 201);
    }
}