<?php

namespace App\Filament\IntegracaoTotem\Resources\SalaTotem;

use App\Filament\IntegracaoTotem\Resources\SalaTotem\Pages\CreateSalaTotem;
use App\Filament\IntegracaoTotem\Resources\SalaTotem\Pages\EditSalaTotem;
use App\Filament\IntegracaoTotem\Resources\SalaTotem\Pages\ListSalaTotem;
use App\Filament\IntegracaoTotem\Resources\SalaTotem\SalaTotemResource\RelationManagers\AssentosRelationManager;
use App\Filament\IntegracaoTotem\Resources\SalaTotem\Schemas\SalaTotemForm;
use App\Filament\IntegracaoTotem\Resources\SalaTotem\Tables\SalaTotemTable;
use App\Models\Totem\SalaTotem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SalaTotemResource extends Resource
{
    protected static ?string $model = SalaTotem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'numero';
    protected static ?string $navigationLabel = 'Salas';
    protected static ?string $pluralLabel = 'Salas';
    protected static ?string $breadcrumb = 'Salas';
    protected static ?string $slug = 'salas';
    protected static ?string $modelLabel = 'Sala';
    protected static ?string $title = 'Sala';

    public static function form(Schema $schema): Schema
    {
        return SalaTotemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalaTotemTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AssentosRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSalaTotem::route('/'),
            'create' => CreateSalaTotem::route('/create'),
            'edit' => EditSalaTotem::route('/{record}/edit'),
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
