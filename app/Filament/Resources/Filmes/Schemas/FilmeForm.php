<?php

namespace App\Filament\Resources\Filmes\Schemas;

use App\Services\Api\GeneroService;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FilmeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Dados do filme')
                    ->components([
                        TextInput::make('titulo')
                            ->required(),
                        RichEditor::make('sinopse')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('duracao_min')
                            ->required()
                            ->numeric(),
                        Select::make('genero')
                        ->options(fn() => collect((new GeneroService())->listar())->pluck('nome','id')->toArray())

                            ->required(),
                        TextInput::make('classificacao')
                            ->required(),
                        TextInput::make('poster')
                            ->required(),
                    ])->columnSpanFull()->columns(2),
                    
                Repeater::make('sessoes')
                    ->relationship('sessoes') // Assume que existe um relacionamento hasMany
                    ->schema([
                        Select::make('sala_id')
                            ->label('Sala')
                            ->relationship(name: 'sala', titleAttribute: 'nome')
                            ->createOptionAction(
                                fn (Action $action) => $action->modalWidth('3xl'),
                            )
                            ->required(),

                        DateTimePicker::make('data_hora')
                            ->label('Data e Hora')
                            ->required(),

                        TextInput::make('preco')
                            ->label('Preço')
                            ->required()
                            ->numeric()
                            ->prefix('R$'),

                        Toggle::make('disponivel')
                            ->label('Disponível')
                            ->default(true),
                    ])->columnSpanFull()
                    ->columns(2)
                    ->addActionLabel('Adicionar sessão')
                    ->collapsible()
            ]);
    }
}
