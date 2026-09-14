<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::lower($request->input(Fortify::username())).'|'.$request->ip();

            return Limit::perMinute(5)->by($throttleKey);
        });

        // Use the admin login view for Fortify's /login route so the package can resolve the
        // LoginViewResponse contract. Adjust if you have a different auth view.
        Fortify::loginView(function () {
            return View::make('admin.login');
        });

        // Note: Fortify's routes are registered by the package or custom configuration.
    }
}