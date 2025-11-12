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
            $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'not set';
            $https = $_SERVER['HTTPS'] ?? 'not set';
            $forwarded = $_SERVER['HTTP_FORWARDED'] ?? 'not set';
    
            // Exibe cabeçalhos diretamente na resposta (apenas para teste)
            echo "<pre>";
            echo "X-Forwarded-Proto: {$forwardedProto}\n";
            echo "HTTPS: {$https}\n";
            echo "Forwarded: {$forwarded}\n";
            echo "</pre>";
            exit;
        }
    }
}
