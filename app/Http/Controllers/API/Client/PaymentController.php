<?php

namespace App\Http\Controllers\API\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function callback(Request $request)
    {
        $subscriptionId = $request->get('subscription_id');
        $successUrl = $request->query('success_url', config('app.front_end_success_url'));

        DB::beginTransaction();
        try {
            $subscription = Subscription::findOrFail($subscriptionId);
            $paymentStatus = $this->paymentService->getPaymentStatus($subscription->invoice_id);

            if ($paymentStatus['Data']['InvoiceStatus'] === 'Paid') {
                $subscription->update([
                    'status' => 'active',
                    'payment_status' => 'paid',
                    'start_date' => now(),
                    'end_date' => now()->addDays($subscription->package->duration ?? 30),
                ]);
            } else {
                $subscription->update(['payment_status' => 'failed']);
                return redirect($successUrl . '?status=failed&message=Payment not successful');
            }

            DB::commit();
            return redirect($successUrl . '?status=success&subscription_id=' . $subscription->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect($successUrl . '?status=failed&message=' . urlencode($e->getMessage()));
        }
    }

    public function error(Request $request)
    {
        $subscriptionId = $request->get('subscription_id');
        $errorUrl = $request->query('error_url', config('app.front_end_error_url'));

        try {
            $subscription = Subscription::findOrFail($subscriptionId);
            $subscription->update(['payment_status' => 'failed']);
            return redirect($errorUrl . '?status=failed&subscription_id=' . $subscription->id);
        } catch (\Exception $e) {
            return redirect($errorUrl . '?status=failed&message=' . urlencode($e->getMessage()));
        }
    }
}
