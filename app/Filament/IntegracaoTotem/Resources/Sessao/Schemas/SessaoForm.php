<?php

namespace App\Filament\IntegracaoTotem\Resources\Sessao\Schemas;

use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Leandrocfe\FilamentPtbrFormFields\Money;

class SessaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        DateTimePicker::make('inicio')
                            ->label('Data e hora de início')
                            ->seconds(false)
                            ->reactive()
                            ->required()
                            ->before('fim')
                            ->validationMessages([
                                'before' => 'Data de início tem de ser menor que data de fim',
                            ]),
                        DateTimePicker::make('fim')
                            ->label('Data e hora de fim')
                            ->seconds(false)
                            ->reactive()
                            ->required()
                            ->after("inicio")
                            ->validationMessages([
                                'after' => 'Data de fim tem de ser maior que data de início',
                            ])
                            ->rules([
                                fn(Get $get): Closure => self::validarDuracaoMinimaDeAcordoComOFilme($get),
                                fn(Get $get): Closure => self::validarConflitoHorarios($get),
                            ]),
                        Select::make('filme_id')
                            ->label('Filme')
                            ->reactive()
                            ->relationship('filme', 'titulo')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('sala_id')
                            ->label('Sala')
                            ->reactive()
                            ->relationship('sala', 'numero')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columns(2),
                        Select::make('tipo_sessao_id')
                            ->label('Tipo de sessão')
                            ->options([
                                2 => 'Normal',
                                1 => '3D',
                                3 => 'Autismo',
                            ])
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columns(2),
                        Select::make('tipo_idioma_id')
                            ->label('Tipo de idioma')
                            ->options([
                                1 => 'Dublado',
                                2 => 'Legendado',
                                3 => 'Idioma original',
                            ])
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columns(2),
                        Money::make('preco')
                            ->label('Valor')
                            ->default(30.00)
                            ->required()
                    ]),
                Section::make('Mapa da uso da sala')
                    ->icon(Heroicon::Map)
                    ->description("Este é o mapa de uso da sala. Aqui você pode visualizar os assentos reservados nesta sessão.")
                    ->columnSpanFull()
                    ->schema([
                        View::make('components.mapa-assentos')
                            ->columnSpanFull()
                            ->viewData(function ($record) {
                                $sala = \App\Models\Totem\SalaTotem::find($record->sala_id);
                                
                                $record?->load('sessoesAssentos');
                                return [
                                    'quantidade_fileiras' => $sala?->quantidade_fileiras,
                                    'quantidade_assentos_por_fileira' => $sala?->quantidade_assentos_por_fileira,
                                    'assentos' => $sala?->assentos,
                                    'ehMapaUso' => true,
                                    'sessoesAssentos' => $record?->sessoesAssentos
                                ];
                            })
                    ])
            ]);
    }

    private static function validarDuracaoMinimaDeAcordoComOFilme(Get $get): Closure
    {
        return function (string $attribute, $value, Closure $fail) use ($get) {
            $inicio = $get('inicio');
            $fim = $value;
            $filmeId = $get('filme_id');


            if (!$inicio || !$fim || !$filmeId) {
                return;
            }

            $filme = \App\Models\Totem\FilmeTotem::find($filmeId);

            if (!$filme) {
                return;
            }

            $duracaoSessao = Carbon::parse($inicio)->diffInMinutes(Carbon::parse($fim));

            if ($duracaoSessao < $filme->duracao_em_minutos) {
                $fail("A duração da sessão ({$duracaoSessao} min) deve ser no mínimo {$filme->duracao_em_minutos} minutos.");
            }
        };
    }

    private static function validarConflitoHorarios(Get $get): Closure
    {
        return function (string $attribute, $value, Closure $fail) use ($get) {
            $inicio = $get('inicio');
            $fim = $value;
            $salaId = $get('sala_id');
            $sessaoId = $get('id');

            if (!$inicio || !$fim || !$salaId) {
                return;
            }

            $conflito = \App\Models\Totem\SessaoTotem::query()
                ->where('sala_id', $salaId)
                ->when($sessaoId, fn($query) => $query->where('id', '!=', $sessaoId))
                ->where('inicio', '<=', $fim)
                ->where('fim', '>=', $inicio)
                ->exists();

            if ($conflito) {
                $fail('Já existe uma sessão agendada para esta sala neste horário.');
            }
        };
    }
}
