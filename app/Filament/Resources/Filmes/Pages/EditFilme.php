<?php

namespace App\Filament\Resources\Filmes\Pages;

use App\Filament\Resources\Filmes\FilmeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFilme extends EditRecord
{
    protected static string $resource = FilmeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
