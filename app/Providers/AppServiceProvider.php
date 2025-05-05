<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CaptainReview;
use App\Observers\CaptainReviewObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        CaptainReview::observe(CaptainReviewObserver::class);
    }
}
