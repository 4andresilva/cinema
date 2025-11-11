<?php

namespace App\Filament\IntegracaoTotem\Widgets;

use App\Models\Totem\Pagamento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class FormasPagamentoChart extends ChartWidget
{
    protected ?string $heading = 'Pagamentos por Forma de Pagamento';

    protected int | string | array $columnSpan = '1'; 
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Pagamento::query()
            ->select('forma_pagamento_id', DB::raw('COUNT(*) as total'))
            ->groupBy('forma_pagamento_id')
            ->with('formaPagamento')
            ->get()
            ->map(fn ($p) => [
                'nome' => $p->formaPagamento->nome ?? 'Desconhecido',
                'total' => $p->total,
            ]);

        $labels = $data->pluck('nome')->toArray();
        $values = $data->pluck('total')->toArray();

        // 🎨 Paleta de cores automática
        $colors = [
            '#3b82f6', // azul
            '#10b981', // verde
            '#f59e0b', // amarelo
            '#ef4444', // vermelho
            '#8b5cf6', // roxo
            '#14b8a6', // ciano
            '#ec4899', // rosa
        ];

        // Caso existam mais formas de pagamento do que cores, repete o array
        $colors = array_slice(array_merge($colors, $colors), 0, count($labels));

        return [
            'datasets' => [
                [
                    'label' => 'Formas de Pagamento',
                    'data' => $values,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
