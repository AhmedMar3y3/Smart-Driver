<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use Carbon\Carbon;
use App\Enums\Status;

class UpdateExpiredCars extends Command
{
    protected $signature = 'cars:expire';
    protected $description = 'Update expiry_status of cars that have passed their expires_at date';

    public function handle()
    {
        $expiredCars = Car::where('expires_at', '<', Carbon::now())
            ->where('expiry_status', 'active')
            ->where('status', '!=', Status::SOLD->value)
            ->get();

        foreach ($expiredCars as $car) {
            $car->update(['expiry_status' => 'expired']);
        }

        $this->info('Expired cars have been updated successfully.');
    }
}   