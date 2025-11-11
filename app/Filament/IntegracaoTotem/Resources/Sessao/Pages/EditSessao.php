<?php

namespace App\Filament\IntegracaoTotem\Resources\Sessao\Pages;

use App\Filament\IntegracaoTotem\Resources\Sessao\SessaoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSessao extends EditRecord
{
    protected static string $resource = SessaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->disabled(),
        ];
    }
}
