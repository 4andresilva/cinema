<?php

namespace App\Filament\IntegracaoTotem\Widgets;

use App\Models\Totem\Pagamento;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;

class LastPayments extends TableWidget
{
    protected static ?string $heading = 'Últimos Pagamentos';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Pagamento::query()
                ->with(['ingresso', 'formaPagamento'])
                ->latest('criado_em')
            )
            ->columns([
                /* TextColumn::make('ingresso.id')
                    ->label('Ingresso')
                    ->getStateUsing(fn ($record) => $record->ingresso?->id ?? '—')
                    ->sortable(), */
                TextColumn::make('ingresso.documento_responsavel')
                    ->label('Cliente')
                    ->getStateUsing(fn ($record) => $record->ingresso->documento_responsavel ?? '—')
                    ->sortable(),

                TextColumn::make('formaPagamento.nome')
                    ->label('Forma de Pagamento')
                    ->getStateUsing(fn ($record) => $record->formaPagamento?->nome ?? '—')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'CartaoCredito' => 'primary',
                        'Pix' => 'success',
                        'Dinheiro' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('valor_total')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->color(fn ($record) => $record->valor_total > 100 ? 'success' : 'gray')
                    ->sortable(),

                TextColumn::make('criado_em')
                    ->label('Pago em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ]);
    }
}
