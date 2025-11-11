<?php

namespace App\Filament\Resources\Salas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Enums\TipoSala;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Support\Icons\Heroicon;

class SalaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cinema_id')
                    ->relationship('cinema', 'nome')
                    ->required(),
                TextInput::make('nome')
                    ->required(),
                TextInput::make('capacidade')
                    ->required()
                    ->numeric(),
                Select::make('tipo')
                    ->options(TipoSala::options())
                    ->required(),
                Toggle::make('disponivel')
                    ->required()
                    ->default(true),
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
                                ];
                            })
                    ])
            ]);
    }
}
