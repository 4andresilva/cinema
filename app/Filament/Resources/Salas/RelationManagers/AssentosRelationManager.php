<?php

namespace App\Filament\Resources\Salas\RelationManagers;

use App\Filament\Resources\Assentos\AssentoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class AssentosRelationManager extends RelationManager
{
    protected static string $relationship = 'assentos';

    protected static ?string $relatedResource = AssentoResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
