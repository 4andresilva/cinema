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
        Log::info('--- Render proxy test ---');
        Log::info('X-Forwarded-Proto: ' . ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'not set'));
        Log::info('HTTPS: ' . ($_SERVER['HTTPS'] ?? 'not set'));
        Log::info('Forwarded: ' . ($_SERVER['HTTP_FORWARDED'] ?? 'not set'));


        /* if ($this->app->environment('production')) {
            $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null;
            $https = $_SERVER['HTTPS'] ?? null;

            if ($forwardedProto === 'https' || $https === 'on') {
                URL::forceScheme('https');
            }
        } */
    }
}
