<?php

namespace App\Providers\Filament;

use App\Filament\IntegracaoTotem\Widgets\CinemaStatsOverview;
use App\Filament\IntegracaoTotem\Widgets\FormasPagamentoChart;
use App\Filament\IntegracaoTotem\Widgets\LastPayments;
use App\Filament\IntegracaoTotem\Widgets\PagamentosPorDiaChart;
use App\Http\Middleware\CheckAdminOrVendedor;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class IntegracaoTotemPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('integracao-totem')
            ->path('cinema-api')
            ->authGuard('web')
            /* ->login() */
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugin(
                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile()
                    ->myProfileComponents([
                        'personal_info' => \App\Livewire\PersonalInfoCustom::class,
                    ])
            )

            
            ->maxContentWidth(Width::Full)
            ->discoverResources(in: app_path('Filament/IntegracaoTotem/Resources'), for: 'App\Filament\IntegracaoTotem\Resources')
            ->discoverPages(in: app_path('Filament/IntegracaoTotem/Pages'), for: 'App\Filament\IntegracaoTotem\Pages')
            ->pages([
                \App\Filament\IntegracaoTotem\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/IntegracaoTotem/Widgets'), for: 'App\Filament\IntegracaoTotem\Widgets')
            ->widgets([
                LastPayments::class,
                CinemaStatsOverview::class,
                PagamentosPorDiaChart::class,
                FormasPagamentoChart::class
            ])

            ->homeUrl(function () {
                $user = filament()->auth()->user();
                /* dd($user->role); */
                if ($user->role === 'admin') {
                    return route('filament.integracao-totem.pages.dashboard');
                }
            
                if ($user->role === 'vendedor') {
                    return '/cinema-api/filmes';
                }

                if ($user->role === 'cliente') {
                    return '/cliente';
                }
            
                return '/';
            })

            ->viteTheme('resources/css/filament/integracao-totem/theme.css')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                CheckAdminOrVendedor::class
            ]);
    }
}
