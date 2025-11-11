<?php

namespace App\Filament\Resources\Cinemas;

use App\Filament\Resources\Cinemas\Pages\CreateCinema;
use App\Filament\Resources\Cinemas\Pages\EditCinema;
use App\Filament\Resources\Cinemas\Pages\ListCinemas;
use App\Filament\Resources\Cinemas\Schemas\CinemaForm;
use App\Filament\Resources\Cinemas\Tables\CinemasTable;
use App\Models\Cinema;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Resources\Cinemas\RelationManagers\SalasRelationManager;
use Illuminate\Database\Eloquent\Builder;

class CinemaResource extends Resource
{
    protected static ?string $model = Cinema::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('salas');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'Cinema';

    public static function form(Schema $schema): Schema
    {
        return CinemaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CinemasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SalasRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCinemas::route('/'),
            'create' => CreateCinema::route('/create'),
            'edit' => EditCinema::route('/{record}/edit'),
        ];
    }
}
