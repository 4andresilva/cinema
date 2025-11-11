<?php

namespace App\Filament\IntegracaoTotem\Resources\SalaTotem\SalaTotemResource\RelationManagers;

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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssentosRelationManager extends RelationManager
{
    protected static string $relationship = 'assentos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tipo_assento_id')
                    ->relationship('tipoAssento', 'nome')
                    ->required(),
                TextInput::make('fileira')
                    ->required(),
                TextInput::make('coluna')
                    ->required()
                    ->numeric(),
                Toggle::make('ativo')
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('coluna')
            ->columns([
                TextColumn::make('tipoAssento.nome')
                    ->searchable(),
                TextColumn::make('fileira')
                    ->searchable(),
                TextColumn::make('coluna')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('ativo')
                    ->boolean(),
                TextColumn::make('criado_em')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('atualizado_em')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
