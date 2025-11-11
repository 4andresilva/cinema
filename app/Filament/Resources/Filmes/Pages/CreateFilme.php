<?php

namespace App\Filament\Resources\Filmes\Pages;

use App\Filament\Resources\Filmes\FilmeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFilme extends CreateRecord
{
    protected static string $resource = FilmeResource::class;
}
