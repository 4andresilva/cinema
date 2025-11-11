<?php

namespace App\Filament\IntegracaoTotem\Widgets;

use App\Models\Totem\Pagamento;
use App\Models\Totem\SessaoTotem;
use App\Models\Totem\FilmeTotem;
use App\Models\Totem\FormaPagamento;
use App\Models\Totem\Ingresso;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Filament\Support\Enums\IconPosition;

class CinemaStatsOverview extends BaseWidget
{
    protected ?string $heading = 'Indicadores do Cinema';
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $filmeMaisAssistido = FilmeTotem::query()
            ->select('filme.titulo', DB::raw('COUNT(sessao.id) as total'))
            ->join('sessao', 'sessao.filme_id', '=', 'filme.id')
            ->groupBy('filme.id')
            ->orderByDesc('total')
            ->first();

        $horarioMaisMovimentado = SessaoTotem::query()
            ->select(DB::raw("EXTRACT(HOUR FROM inicio) as hora"), DB::raw('COUNT(*) as total'))
            ->groupBy('hora')
            ->orderByDesc('total')
            ->first();

        $formaPagamentoMaisUsada = FormaPagamento::query()
            ->select('forma_pagamento.nome', DB::raw('COUNT(pagamento.id) as total'))
            ->join('pagamento', 'pagamento.forma_pagamento_id', '=', 'forma_pagamento.id')
            ->groupBy('forma_pagamento.id')
            ->orderByDesc('total')
            ->first();

        $maiorComprador = Ingresso::query()
            ->select('documento_responsavel', DB::raw('SUM(pagamento.valor_total) as total_gasto'))
            ->join('pagamento', 'pagamento.ingresso_id', '=', 'ingresso.id')
            ->groupBy('documento_responsavel')
            ->orderByDesc('total_gasto')
            ->first();

        return [
            Stat::make('🎬 Filme mais assistido', $filmeMaisAssistido?->titulo ?? '—')
                ->description(($filmeMaisAssistido?->total ?? 0) . ' sessões')
                ->color('info'),

            Stat::make('🕓 Horário de maior movimento', $horarioMaisMovimentado ? "{$horarioMaisMovimentado->hora}h" : '—')
                ->description(($horarioMaisMovimentado?->total ?? 0) . ' sessões nesse horário')
                ->color('warning'),

            Stat::make('💳 Forma de pagamento mais usada', $formaPagamentoMaisUsada?->nome ?? '—')
                ->description(($formaPagamentoMaisUsada?->total ?? 0) . ' pagamentos')
                ->color('success'),

            Stat::make('🏆 Cliente Top Comprador', $maiorComprador?->documento_responsavel ?? '—')
                ->description('Gasto total R$ ' . number_format($maiorComprador?->total_gasto ?? 0, 2, ',', '.'))
                ->color('primary'),
        ];
    }
}
