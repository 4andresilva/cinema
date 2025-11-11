<?php

namespace App\Filament\IntegracaoTotem\Resources\FilmeTotems\Pages;

use App\Filament\IntegracaoTotem\Resources\FilmeTotems\FilmeTotemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFilmeTotem extends EditRecord
{
    protected static string $resource = FilmeTotemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
