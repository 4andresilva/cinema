<?php

namespace App\Filament\IntegracaoTotem\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Facades\Filament;

class Dashboard extends BaseDashboard
{
    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        // Somente admin pode acessar o painel
        return $user && $user->role === 'admin';
    }
}
