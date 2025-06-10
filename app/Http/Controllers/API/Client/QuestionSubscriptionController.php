<?php

namespace App\Http\Controllers\API\Client;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\QuestionSubscriptionService;

class QuestionSubscriptionController extends Controller
{
    use HttpResponses;
    protected $subscriptionService;

    public function __construct(QuestionSubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        $client = auth('client')->user();
        $packageId = $request->input('package_id');
        $successUrl = $request->input('success_url');
        $errorUrl = $request->input('error_url');
        $subscription = $this->subscriptionService->subscribe($client, $packageId, $successUrl, $errorUrl);
        return $this->successWithDataResponse([
            'invoice_url' => $subscription->invoice_url,
            'subscription_id' => $subscription->id,
        ]);
    }
}
