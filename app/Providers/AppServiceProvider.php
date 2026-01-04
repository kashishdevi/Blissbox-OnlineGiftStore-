<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\AdminSidebarComposer;

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
        
        // Share admin sidebar variables with all admin views
        View::composer('admin.layouts.sidebar', AdminSidebarComposer::class);
    }
}
