<?php

namespace App\Filament\IntegracaoTotem\Resources\SalaTotem\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalaTotemTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero')
                    ->label("Sala")
                    ->formatStateUsing(function ($record) {
                        return "Sala " . $record->numero;
                    }),
                TextColumn::make('tipo_sala_id')
                    ->label("Tipo de sala")
                    ->formatStateUsing(function ($record) {
                        if ($record->tipo_sala_id === 1) {
                            return "Sala normal";
                        } elseif ($record->tipo_sala_id === 2) {
                            return "Sala VIP";
                        }
                        
                        return "Sala 4D";
                    })
            ]);
    }
}
