<?php

namespace App\Filament\Resources\Filmes;

use App\Filament\Resources\Filmes\Pages\CreateFilme;
use App\Filament\Resources\Filmes\Pages\EditFilme;
use App\Filament\Resources\Filmes\Pages\ListFilmes;
use App\Filament\Resources\Filmes\Schemas\FilmeForm;
use App\Filament\Resources\Filmes\Tables\FilmesTable;
use App\Models\Filme;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilmeResource extends Resource
{
    protected static ?string $model = Filme::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Film;

    protected static ?string $recordTitleAttribute = 'titulo';

    public static function form(Schema $schema): Schema
    {
        return FilmeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilmesTable::configure($table);
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
            'index' => ListFilmes::route('/'),
            'create' => CreateFilme::route('/create'),
            'edit' => EditFilme::route('/{record}/edit'),
        ];
    }
}
