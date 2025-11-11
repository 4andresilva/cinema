<?php

namespace App\Filament\IntegracaoTotem\Resources\FilmeTotems\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SessoesRelationManager extends RelationManager
{
    protected static string $relationship = 'sessoes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('sala_id')
                    ->relationship('sala', 'numero')
                    ->required(),
                Select::make('tipo_sessao_id')
                    ->relationship('tipoSessao', 'nome')
                    ->required(),
                Select::make('tipo_idioma_id')
                    ->relationship('tipoIdioma','nome')
                    ->required(),
                DateTimePicker::make('inicio')
                    ->required(),
                DateTimePicker::make('fim')
                    ->required(),
                Toggle::make('ativo')
                    ->required(),
                TextInput::make('preco')
                    ->required()
                    ->numeric()
                    ->default(30),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('filme_id')
            ->columns([
                TextColumn::make('sala.numero')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tipoSessao.nome')
                    ->sortable(),
                TextColumn::make('tipoIdioma.nome')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('inicio')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('fim')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('ativo')
                    ->boolean(),
                TextColumn::make('criado_em')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('atualizado_em')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('preco')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
