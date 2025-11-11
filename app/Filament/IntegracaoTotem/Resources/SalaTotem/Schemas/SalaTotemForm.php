<?php

namespace App\Filament\IntegracaoTotem\Resources\SalaTotem\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SalaTotemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('numero')
                            ->label('Número')
                            ->numeric()
                            ->required(),

                        Select::make('tipo_sala_id')
                            ->label('Tipo de sala')
                            ->options([
                                1 => 'Sala normal',
                                2 => 'Sala VIP',
                                3 => 'Sala 4D',
                            ])
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),

                        TextInput::make('quantidade_fileiras')
                            ->label('Quantidade de fileiras')
                            ->numeric()
                            ->required(),

                        TextInput::make('quantidade_assentos_por_fileira')
                            ->label('Quantidade de assentos por fileira')
                            ->numeric()
                            ->required(),
                    ]),
                Section::make('Mapa da sala')
                    ->icon(Heroicon::Map)
                    ->description("Este é o mapa de assentos da sala. Aqui você pode visualizar a disposição dos assentos e planejar a ocupação conforme necessário. Caso seja necessário criar um novo mapa ou editar o atual, entre em contato com o time de desenvolvimento.")
                    ->columnSpanFull()
                    ->schema([
                        View::make('components.mapa-assentos')
                            ->columnSpanFull()
                            ->viewData(function ($record) {
                                $record?->load('assentos'); // ← carrega aqui
                                return [
                                    'quantidade_fileiras' => $record?->quantidade_fileiras,
                                    'quantidade_assentos_por_fileira' => $record?->quantidade_assentos_por_fileira,
                                    'assentos' => $record?->assentos,
                                    'ehMapaUso' => false
                                ];
                            })
                    ])
            ]);
    }
}
