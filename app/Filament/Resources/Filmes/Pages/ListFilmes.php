<?php

namespace App\Filament\Resources\Filmes\Pages;

use App\Filament\Resources\Filmes\FilmeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilmes extends ListRecords
{
    protected static string $resource = FilmeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
