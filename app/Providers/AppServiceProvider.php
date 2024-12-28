<?php

namespace App\Providers;

use App\Models\AdditionalInformation;
use App\Models\Crop;
use App\Models\User;
use App\Observers\MultiModelObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Paginator::useBootstrap();
        // Register the observer for User and Crop models
        User::observe(MultiModelObserver::class);
        Crop::observe(MultiModelObserver::class);
        AdditionalInformation::observe(MultiModelObserver::class);
    }
}
