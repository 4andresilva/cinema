<?php

namespace App\Filament\IntegracaoTotem\Resources\SalaTotem\Pages;

use App\Filament\IntegracaoTotem\Resources\SalaTotem\SalaTotemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSalaTotem extends CreateRecord
{
    protected static string $resource = SalaTotemResource::class;
    protected static ?string $navigationLabel = 'Salas';
}
