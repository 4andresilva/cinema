<?php

namespace App\Filament\IntegracaoTotem\Resources\Sessao;

use App\Filament\IntegracaoTotem\Resources\Sessao\Pages\CreateSessao;
use App\Filament\IntegracaoTotem\Resources\Sessao\Pages\EditSessao;
use App\Filament\IntegracaoTotem\Resources\Sessao\Pages\ListSessao;
use App\Filament\IntegracaoTotem\Resources\Sessao\Schemas\SessaoForm;
use App\Filament\IntegracaoTotem\Resources\Sessao\Tables\SessaoTable;
use App\Models\Totem\SessaoTotem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SessaoResource extends Resource
{
    protected static ?string $model = SessaoTotem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Sessões';
    protected static ?string $pluralLabel = 'Sessões';
    protected static ?string $label = 'Sessão';
    protected static ?string $breadcrumb = 'Sessões';
    protected static ?string $slug = 'sessoes';

    public static function form(Schema $schema): Schema
    {
        return SessaoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessaoTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSessao::route('/'),
            'create' => CreateSessao::route('/create'),
            'edit' => EditSessao::route('/{record}/edit'),
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
