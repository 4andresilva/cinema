<?php

namespace App\Filament\Resources\Cinemas\Pages;

use App\Filament\Resources\Cinemas\CinemaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCinema extends EditRecord
{
    protected static string $resource = CinemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
