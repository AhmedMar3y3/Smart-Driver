<?php

namespace App\Services;

use App\Exceptions\CustomException;
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
        $package = QuestionPackage::find($packageId);
        if (!$package) {
            throw new CustomException('حزمة غير صالحة.');
        }

        if($client->hasActiveSubscription($packageId) || $client->hasCompletedSubscription($packageId)) {
            throw new CustomException('لديك بالفعل اشتراك نشط من نفس النوع.');
        }

        $subscription = QuestionSubscription::create([
            'client_id' => $client->id,
            'question_package_id' => $package->id,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $paymentData = $this->paymentService->initiatePayment(
            $subscription,
            config('MyFatoorah.front_end_success_url'),
            config('MyFatoorah.front_end_error_url'),
            'question.payment.callback',
            'question.payment.error'
        );
        $subscription->update([
            'invoice_id' => $paymentData['InvoiceId'],
            'invoice_url' => $paymentData['InvoiceURL'],
            'payment_status' => 'initiated',
        ]);

        return $subscription;
    }
}