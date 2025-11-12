<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production')) {
            $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null;

            // Força HTTPS apenas se o proxy indicar isso
            if ($forwardedProto === 'https') {
                URL::forceScheme('https');
            }
        }
    }
}
