<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('MyFatoorah.token');
        $this->baseUrl = config('MyFatoorah.url');
    }

    public function initiatePayment($subscription, $successUrl, $errorUrl, $callbackRoute, $errorRoute)
    {
        $user = $subscription->subscriber;
        $payload = [
            'CustomerName' => $user->name,
            'NotificationOption' => 'LNK',
            'InvoiceValue' => $subscription->package->price,
            'CurrencyCode' => 'AED',
            'DisplayCurrencyIso' => 'AED',
            'CallBackUrl' => route($callbackRoute, [
                'subscription_id' => $subscription->id,
                'success_url' => $successUrl,
            ]),
            'ErrorUrl' => route($errorRoute, [
                'subscription_id' => $subscription->id,
                'error_url' => $errorUrl,
            ]),
            'CustomerEmail' => $user->email,
            'CustomerMobile' => $user->phone ?? '+00000',
            'CustomerReference' => $subscription->id,
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/v2/SendPayment", $payload);

        if (!$response->ok()) {
            throw new \Exception('Payment initiation failed.');
        }

        return $response->json()['Data'];
    }

    public function getPaymentStatus($invoiceId)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/v2/GetPaymentStatus", [
            'KeyType' => 'InvoiceId',
            'Key' => (string) $invoiceId,
        ]);

        if (!$response->ok()) {
            throw new \Exception('Failed to retrieve payment status.');
        }

        return $response->json();
    }
}
