<?php

namespace App\Filament\IntegracaoTotem\Resources\Sessao\Pages;

use App\Filament\IntegracaoTotem\Resources\Sessao\SessaoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSessao extends ListRecords
{
    protected static string $resource = SessaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            /* CreateAction::make()->label("Criar"), */
        ];
    }
}
