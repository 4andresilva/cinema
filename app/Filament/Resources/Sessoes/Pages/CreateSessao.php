<?php

namespace App\Filament\Resources\Sessoes\Pages;

use App\Filament\Resources\Sessoes\SessaoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSessao extends CreateRecord
{
    protected static string $resource = SessaoResource::class;
    protected static ?string $navigationLabel = 'Sessões';
}
