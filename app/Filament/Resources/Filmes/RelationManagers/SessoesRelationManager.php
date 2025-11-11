<?php

namespace App\Filament\Resources\Filmes\RelationManagers;

use App\Filament\Resources\Sessoes\SessaoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class SessoesRelationManager extends RelationManager
{
    protected static string $relationship = 'sessoes';

    protected static ?string $relatedResource = SessaoResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
