<?php

namespace App\Filament\IntegracaoTotem\Resources\SalaTotem\Pages;

use App\Filament\IntegracaoTotem\Resources\SalaTotem\SalaTotemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSalaTotem extends ListRecords
{
    protected static string $resource = SalaTotemResource::class;
    protected static ?string $title = 'Salas';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Criar'),
        ];
    }
}
