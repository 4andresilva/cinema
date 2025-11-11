<?php

namespace App\Filament\IntegracaoTotem\Resources\FilmeTotems;

use App\Filament\IntegracaoTotem\Resources\FilmeTotems\Pages\CreateFilmeTotem;
use App\Filament\IntegracaoTotem\Resources\FilmeTotems\Pages\EditFilmeTotem;
use App\Filament\IntegracaoTotem\Resources\FilmeTotems\Pages\ListFilmeTotems;
use App\Filament\IntegracaoTotem\Resources\FilmeTotems\RelationManagers\SessoesRelationManager;
use App\Filament\IntegracaoTotem\Resources\FilmeTotems\Schemas\FilmeTotemForm;
use App\Filament\IntegracaoTotem\Resources\FilmeTotems\Tables\FilmeTotemsTable;
use App\Models\Totem\FilmeTotem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilmeTotemResource extends Resource
{
    protected static ?string $model = FilmeTotem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'titulo';
    protected static ?string $navigationLabel = 'Filmes';
    protected static ?string $modelLabel = 'Filme';
    protected static ?string $title = 'Filme';
    protected static ?string $slug = 'filmes';

    public static function form(Schema $schema): Schema
    {
        return FilmeTotemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilmeTotemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SessoesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFilmeTotems::route('/'),
            'create' => CreateFilmeTotem::route('/create'),
            'edit' => EditFilmeTotem::route('/{record}/edit'),
        ];
    }

    // Força o Filament a usar a policy
    public static function canViewAny(): bool
    {
        return static::can('viewAny');
    }

    public static function canCreate(): bool
    {
        return static::can('create');
    }

    public static function canEdit($record): bool
    {
        return static::can('update', $record);
    }

    public static function canDelete($record): bool
    {
        return static::can('delete', $record);
    }
}
