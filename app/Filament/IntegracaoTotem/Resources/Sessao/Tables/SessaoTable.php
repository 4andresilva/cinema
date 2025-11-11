<?php

namespace App\Filament\IntegracaoTotem\Resources\Sessao\Tables;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class SessaoTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inicio')
                    ->label("Início")
                    ->dateTime('d/m/Y H:i'),
                TextColumn::make('fim')
                    ->label("Fim")
                    ->dateTime('d/m/Y H:i'),
                TextColumn::make('filme.titulo')
                    ->label("Filme"),
                TextColumn::make('sala.numero')
                    ->label("Sala"),
                TextColumn::make('tipoSessao.nome')
                    ->label("Tipo de sessão"),
                TextColumn::make('tipoIdioma.nome')
                    ->label("Tipo de idioma"),
                TextColumn::make('preco')
                    ->label('Valor')
                    ->money('BRL')
            ])
            ->filters([
                SelectFilter::make('filme')
                    ->relationship('filme', 'titulo')
                    ->label('Filme')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('sala')
                    ->relationship('sala', 'numero')
                    ->label('Sala')
                    ->searchable()
                    ->preload(),

                DateRangeFilter::make('inicio')
                    ->label('Período')
                    ->defaultToday() // Define hoje como padrão
                    ->withIndicator()
            ])
            ->defaultSort('fim', 'desc');;
    }
}
