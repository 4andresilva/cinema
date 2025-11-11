<?php

namespace App\Filament\Resources\Assentos\Pages;

use App\Filament\Resources\Assentos\AssentoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssento extends EditRecord
{
    protected static string $resource = AssentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
