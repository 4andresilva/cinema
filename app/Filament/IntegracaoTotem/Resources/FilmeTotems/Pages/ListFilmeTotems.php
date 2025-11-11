<?php

namespace App\Filament\IntegracaoTotem\Resources\FilmeTotems\Pages;

use App\Filament\IntegracaoTotem\Resources\FilmeTotems\FilmeTotemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilmeTotems extends ListRecords
{
    protected static string $resource = FilmeTotemResource::class;
    protected static ?string $title = 'Filmes';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Criar')
        ];
    }
}
