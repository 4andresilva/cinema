<?php

namespace App\Filament\Resources\Assentos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssentoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    Select::make('sala_id')
                        ->relationship('sala', 'nome')
                        ->required(),
                    TextInput::make('fila')
                        ->required()
                        ->label('Fila/Fileira'),
                    TextInput::make('numero')
                        ->required()
                        ->numeric(),
                    Toggle::make('disponivel')
                        ->required()
                        ->default(true),
                ])->columns(2)

            ])->columns(1);
    }
}
