<?php

namespace App\Filament\Resources\Assentos;

use App\Filament\Resources\Assentos\Pages\CreateAssento;
use App\Filament\Resources\Assentos\Pages\EditAssento;
use App\Filament\Resources\Assentos\Pages\ListAssentos;
use App\Filament\Resources\Assentos\Schemas\AssentoForm;
use App\Filament\Resources\Assentos\Tables\AssentosTable;
use App\Models\Assento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssentoResource extends Resource
{
    protected static ?string $model = Assento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Squares2x2;

    protected static ?string $recordTitleAttribute = 'numero';

    public static function form(Schema $schema): Schema
    {
        return AssentoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssentosTable::configure($table);
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
            'index' => ListAssentos::route('/'),
            'create' => CreateAssento::route('/create'),
            'edit' => EditAssento::route('/{record}/edit'),
        ];
    }
}
