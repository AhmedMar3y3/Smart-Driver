<?php

namespace App\Http\Controllers\API\Client;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;


class SubscriptionController extends Controller
{
    use HttpResponses;
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribeClient(Request $request)
    {
        $client = auth('client')->user();
        $successUrl = $request->input('success_url');
        $errorUrl = $request->input('error_url');

        try {
            $subscription = $this->subscriptionService->subscribe($client, $request->input('package_id'), $successUrl, $errorUrl);
            return $this->successWithDataResponse([
                'invoice_url' => $subscription->invoice_url,
                'subscription_id' => $subscription->id,
            ]);
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
}