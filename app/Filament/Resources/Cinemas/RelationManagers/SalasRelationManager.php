<?php

namespace App\Filament\Resources\Cinemas\RelationManagers;

use App\Filament\Resources\Salas\SalaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SalasRelationManager extends RelationManager
{
    protected static string $relationship = 'salas';

    protected static ?string $relatedResource = SalaResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
