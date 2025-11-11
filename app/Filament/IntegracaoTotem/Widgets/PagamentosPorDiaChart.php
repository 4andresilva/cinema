<?php

namespace App\Filament\IntegracaoTotem\Widgets;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Totem\Pagamento;
use Filament\Widgets\ChartWidget;

class PagamentosPorDiaChart extends ChartWidget
{
    protected ?string $heading = 'Faturamento por Dia';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Trend::model(Pagamento::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->dateColumn('criado_em')
            ->perDay()
            ->sum('valor_total');

        return [
            'datasets' => [
                [
                    'label' => 'Faturamento Total',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
