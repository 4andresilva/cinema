<?php

namespace App\Filament\Cliente\Widgets;

use App\Models\Totem\Pagamento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClienteResumoStats extends BaseWidget
{
    protected function getStats(): array
    {
        $documento = auth()->user()->documento;
        /* dd($documento); */

        $pagamentos = Pagamento::whereHas('ingresso', fn($q) =>
            $q->where('documento_responsavel', $documento)
        );

        $totalGasto = $pagamentos->sum('valor_total');
        $ingressos = $pagamentos->count();

        return [
            Stat::make('Total gasto', 'R$ ' . number_format($totalGasto, 2, ',', '.')),
            Stat::make('Ingressos comprados', $ingressos),
            Stat::make('Último acesso', now()->format('d/m/Y H:i')),
        ];
    }
}
