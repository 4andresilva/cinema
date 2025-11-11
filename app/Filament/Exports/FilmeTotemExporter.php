<?php

namespace App\Filament\Exports;

use App\Models\Totem\FilmeTotem;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class FilmeTotemExporter extends Exporter
{
    
    protected static ?string $model = FilmeTotem::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('titulo')->label('Título'),
            ExportColumn::make('descricao')->label('Descrição'),
            ExportColumn::make('duracao_em_minutos'),
            ExportColumn::make('classificacao.nome')->label('Classificação'),
            ExportColumn::make('generos.nome')->label('Gêneros'),
            ExportColumn::make('banner_url')->label('Banner URL'),
            ExportColumn::make('trailer_url')->label('Trailer'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your filme totem export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function collection()
    {
        return FilmeTotem::all();
    }
}
