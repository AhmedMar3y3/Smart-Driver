<?php

namespace App\Services;

use App\Models\QuestionSubscription;
use App\Models\QuestionPackage;

class QuestionSubscriptionService
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function subscribe($client, $packageId)
    {
        $package = QuestionPackage::findOrFail($packageId);

        $subscription = QuestionSubscription::create([
            'client_id' => $client->id,
            'question_package_id' => $package->id,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $paymentData = $this->paymentService->initiatePayment($subscription, route('subscription.payment.callback'), route('subscription.payment.error'));
        $subscription->update([
            'invoice_id' => $paymentData['InvoiceId'],
            'invoice_url' => $paymentData['InvoiceURL'],
            'payment_status' => 'initiated',
        ]);

        return $subscription;
    }
}