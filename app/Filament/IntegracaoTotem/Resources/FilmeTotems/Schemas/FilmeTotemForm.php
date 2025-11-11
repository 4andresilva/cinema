<?php

namespace App\Filament\IntegracaoTotem\Resources\FilmeTotems\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;

class FilmeTotemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filmes')
                    ->description('Gerencie os filmes para a exibição no Totem')
                    ->icon(Heroicon::Film)
                    ->schema([
                        TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->columnSpan(3),

                        Textarea::make('descricao')
                            ->label('Sinopse')
                            ->required()
                            ->columnSpan(3)
                            ->rows(7),

                        TextInput::make('direcao')
                            ->label('Direção')
                            ->required()
                            ->columnSpan(3),

                        TextInput::make('elenco')
                            ->label('Elenco')
                            ->required()
                            ->columnSpan(3),

                        TextInput::make('duracao_em_minutos')
                            ->label('Duração (em minutos)')
                            ->numeric()
                            ->required(),

                        Select::make('classificacao_indicativa_id')
                            ->label('Classificação indicativa')
                            ->relationship('classificacao', 'nome')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),

                        Select::make('generos')
                            ->label('Gêneros')
                            ->relationship('generos', 'nome')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columns(2),

                        DatePicker::make('data_lancamento')
                            ->label('Data de lançamento')
                            ->required(),

                        DatePicker::make('data_inicio_cartaz')
                            ->label('Data de início do cartaz')
                            ->required()
                            ->before('data_fim_cartaz')
                            ->validationMessages([
                                'before' => 'Data de início tem de ser menor que data de fim',
                            ]),

                        DatePicker::make('data_fim_cartaz')
                            ->label('Data de fim do cartaz')
                            ->required()
                            ->after('data_inicio_cartaz')
                            ->validationMessages([
                                'after' => 'Data de fim tem de ser maior que data de início',
                            ]),

                        FileUpload::make('capa_url')
                            ->image()
                            ->required()
                            ->label('Imagem da capa')
                            ->disk('public')
                            ->directory('filmes/imagens')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(10240) // 10MB
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/avif'])
                            ->helperText('Formatos aceitos: PNG, JPG, WEBP, AVIF. Máximo 10MB por arquivo.')
                            ->live()
                            ->dehydrateStateUsing(function ($state) {
                                return $state ? Storage::url($state) : null;
                            })
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_string($state) && str_starts_with($state, config('app.url'))) {
                                    $path = str_replace(Storage::url(''), '', $state);
                                    $component->state($path);
                                }
                            }),

                        FileUpload::make('banner_url')
                            ->image()
                            ->required()
                            ->label('Imagem do banner')
                            ->disk('public')
                            ->directory('filmes/imagens')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(10240) // 10MB
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/avif'])
                            ->helperText('Formatos aceitos: PNG, JPG, WEBP, AVIF. Máximo 10MB por arquivo.')
                            ->live()
                            ->dehydrateStateUsing(function ($state) {
                                return $state ? Storage::url($state) : null;
                            })
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_string($state) && str_starts_with($state, config('app.url'))) {
                                    $path = str_replace(Storage::url(''), '', $state);
                                    $component->state($path);
                                }
                            }),

                        TextInput::make('trailer_url')
                            ->label('URL do trailer no YouTube')
                            ->url()
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->columns(3)
            ]);
    }
}
