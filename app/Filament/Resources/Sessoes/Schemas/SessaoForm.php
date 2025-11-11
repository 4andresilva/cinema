<?php

namespace App\Filament\Resources\Sessoes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SessaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('filme_id')
                    ->relationship('filme', 'titulo')
                    ->required(),
                Select::make('sala_id')
                    ->relationship('sala', 'nome')
                    ->required(),
                DateTimePicker::make('data_hora')
                    ->required(),
                TextInput::make('preco')
                    ->required()
                    ->numeric(),
                Toggle::make('disponivel')
                    ->required(),

            ])->columns(2)
        ;
    }
}
