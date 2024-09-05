<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\Contracts\MessageServiceInterface::class, \App\Services\MessageService::class);
        $this->app->bind(\App\Services\Contracts\RecipientServiceInterface::class, \App\Services\RecipientService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
