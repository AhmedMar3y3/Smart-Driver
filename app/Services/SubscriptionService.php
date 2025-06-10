<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Package;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Enums\Status;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function subscribe($user, $packageId, $successUrl = null, $errorUrl = null)
    {
        $package = Package::find($packageId);
        if (!$package) {
            throw new \Exception('حزمة غير صالحة.');
        }

        if ($user instanceof \App\Models\Client && !in_array($package->type, ['car', 'plate'])) {
            throw new \Exception('يمكن للعملاء الاشتراك فقط في باقات السيارات أو اللوحات.');
        }
        if ($user instanceof \App\Models\Captain && $package->type !== 'captain') {
            throw new \Exception('يمكن للكباتن الاشتراك فقط في باقات الكابتن.');
        }

        $existingSubscription = $user->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereHas('package', fn($q) => $q->where('type', $package->type))
            ->first();

        if ($existingSubscription) {
            if ($user instanceof \App\Models\Captain) {
                throw new \Exception('لديك بالفعل اشتراك كابتن نشط.');
            } else {
                throw new \Exception("لديك بالفعل اشتراك نشط من نوع {$package->type}.");
            }
        }

        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($package->duration ?? 30);
        $subscription = Subscription::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'subscriber_id' => $user->id,
            'subscriber_type' => get_class($user),
            'package_id' => $package->id,
            'status' => SubscriptionStatus::PENDING->value,
        ]);

        try {
            $paymentData = $this->paymentService->initiatePayment(
                $subscription,
                $successUrl,
                $errorUrl,
                'subscription.payment.callback',
                'subscription.payment.error'
            );
            $subscription->update([
                'invoice_id' => $paymentData['InvoiceId'],
                'invoice_url' => $paymentData['InvoiceURL'],
                'payment_status' => PaymentStatus::INITIATED->value,
            ]);
        } catch (\Exception $e) {
            Log::error('فشل بدء الدفع عبر MyFatoorah', ['error' => $e->getMessage()]);
            $subscription->delete();
            throw $e;
        }

        return $subscription;
    }

    public function canPostCarAd($client)
    {
        $activeSubscription = $client->subscriptions()
            ->whereHas('package', fn($q) => $q->where('type', 'car'))
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($activeSubscription) {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $adsThisMonth = $client->cars()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            if ($adsThisMonth <= $activeSubscription->package->allowed_ads_per_month) {
                return ['can_post' => true, 'expires_in_days' => $activeSubscription->package->ad_duration];
            } else {
                return ['can_post' => false];
            }
        } else {
            $activeCars = $client->cars()
                ->where('status', '!=', Status::SOLD->value)
                ->count();

            if ($activeCars < 1) {
                return ['can_post' => true, 'expires_in_days' => 15];
            } else {
                return ['can_post' => false];
            }
        }
    }

    public function canPostPlateAd($client)
    {
        $subscription = $client->subscriptions()
            ->whereHas('package', fn($q) => $q->where('type', 'plate'))
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$subscription) {
            return false;
        }

        $adsPosted = $client->plates()
            ->whereBetween('created_at', [$subscription->start_date, $subscription->end_date])
            ->count();

        return $adsPosted < $subscription->package->allowed_ads;
    }
}
