<?php

namespace App\Filament\IntegracaoTotem\Resources\SalaTotem\Pages;

use App\Filament\IntegracaoTotem\Resources\SalaTotem\SalaTotemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSalaTotem extends EditRecord
{
    protected static string $resource = SalaTotemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Editar Sala ' . $this->record->numero;
    }
}
