<?php

namespace App\Filament\Resources\Sessoes;

use App\Filament\Resources\Sessoes\Pages\CreateSessao;
use App\Filament\Resources\Sessoes\Pages\EditSessao;
use App\Filament\Resources\Sessoes\Pages\ListSessoes;
use App\Filament\Resources\Sessoes\Schemas\SessaoForm;
use App\Filament\Resources\Sessoes\Tables\SessoesTable;
use App\Models\Sessao;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SessaoResource extends Resource
{
    protected static ?string $model = Sessao::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;

    protected static ?string $recordTitleAttribute = 'nome';
    protected static ?string $navigationLabel = 'Sessões';
    protected static ?string $slug = 'sessoes';

    public static function form(Schema $schema): Schema
    {
        return SessaoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessoesTable::configure($table);
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
            'index' => ListSessoes::route('/'),
            'create' => CreateSessao::route('/create'),
            'edit' => EditSessao::route('/{record}/edit'),
        ];
    }
}
