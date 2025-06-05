<?php

namespace App\Console\Commands;

use App\Models\Plate;
use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class UpdateExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire';
    protected $description = 'Update the status of expired subscriptions';

    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $expiredSubscriptions = Subscription::where('end_date', '<', $today)
            ->where('status', 'active')
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['status' => 'expired']);
            Plate::where('client_id', $subscription->subscriber_id)->delete();
        }

        $this->info('Expired subscriptions have been updated and related plates have been deleted.');
    }
}