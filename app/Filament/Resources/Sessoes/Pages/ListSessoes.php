<?php

namespace App\Filament\Resources\Sessoes\Pages;

use App\Filament\Resources\Sessoes\SessaoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSessoes extends ListRecords
{
    protected static string $resource = SessaoResource::class;
    protected static ?string $title = 'Sessões';
    protected static ?string $slug = 'sessoes';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
