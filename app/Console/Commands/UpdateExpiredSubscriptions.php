<?php

namespace App\Console\Commands;

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
        Subscription::where('end_date', '<', $today)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $this->info('Expired subscriptions have been updated.');
    }
}