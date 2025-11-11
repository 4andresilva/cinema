<?php

namespace App\Filament\Resources\Sessoes\Pages;

use App\Filament\Resources\Sessoes\SessaoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSessao extends EditRecord
{
    protected static string $resource = SessaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
