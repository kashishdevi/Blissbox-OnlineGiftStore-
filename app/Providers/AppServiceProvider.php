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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure Passport token expiration (if Passport is installed)
        if (class_exists(\Laravel\Passport\Passport::class)) {
            \Laravel\Passport\Passport::tokensExpireIn(now()->addDays(15));
            \Laravel\Passport\Passport::refreshTokensExpireIn(now()->addDays(30));
        }
    }
}
