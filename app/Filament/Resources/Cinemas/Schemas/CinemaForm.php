<?php

namespace App\Filament\Resources\Cinemas\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class CinemaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('')
                    ->components([
                        Wizard::make([
                            // 🧩 Etapa 1: Dados do Cinema
                            Step::make('Cinema')
                                ->description('Dados do Cinema')
                                ->schema([
                                    TextInput::make('nome')
                                        ->label('Nome do Cinema')
                                        ->required(),
                                    TextInput::make('endereco')
                                        ->label('Endereço')
                                        ->required(),
                                    TextInput::make('telefone')
                                        ->label('Telefone')
                                        ->tel(),
                                    Toggle::make('disponivel')
                                        ->label('Disponível')
                                        ->default(true),
                                ]),

                            // 🧩 Etapa 2: Salas
                            Step::make('Salas')
                                ->schema([
                                    Repeater::make('salas')
                                        ->label('Salas do Cinema')
                                        ->relationship('salas')
                                        ->schema([

                                            TextInput::make('nome')
                                                ->label('Nome da Sala')
                                                ->required()
                                                ->live(debounce: 500),

                                            TextInput::make('capacidade')
                                                ->label('Capacidade Total')
                                                ->numeric()
                                                ->required()
                                                ->minValue(1),

                                            Select::make('tipo')
                                                ->label('Tipo')
                                                ->options([
                                                    '2D' => '2D',
                                                    '3D' => '3D',
                                                    'IMAX' => 'IMAX',
                                                ])
                                                ->required(),

                                            Toggle::make('disponivel')
                                                ->label('Disponível')
                                                ->default(true),

                                            TextInput::make('fileiras')
                                                ->label('Nº de Fileiras')
                                                ->numeric()
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function (Set $set, Get $get, ?int $state) {
                                                    $colunas = $get('assentos_por_fileira');
                                                    if ($state && $colunas) {
                                                        self::gerarAssentos($set, $get, $state, $colunas);
                                                    }
                                                }),

                                            TextInput::make('assentos_por_fileira')
                                                ->label('Assentos por Fileira')
                                                ->numeric()
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function (Set $set, Get $get, ?int $state) {
                                                    $fileiras = $get('fileiras');
                                                    if ($fileiras && $state) {
                                                        self::gerarAssentos($set, $get, $fileiras, $state);
                                                    }
                                                }),

                                                Repeater::make('assentos')
                                                ->label('Assentos')
                                                ->relationship('assentos')
                                                ->schema([
                                                    TextInput::make('fila')
                                                        ->label('Fila')
                                                        ->required()
                                                        ->maxLength(5)
                                                        ->readOnly()
                                                        ->dehydrated(true),
                                                        
                                                    TextInput::make('numero')
                                                        ->label('Número')
                                                        ->numeric()
                                                        ->required()
                                                        ->readOnly()
                                                        ->dehydrated(true),

                                                    Toggle::make('disponivel')
                                                        ->label('Disponível')
                                                        ->default(true),
                                                ])
                                                ->grid(4)
                                                ->columnSpanFull()
                                                ->collapsed()
                                                ->itemLabel(fn (array $state): ?string =>
                                                    isset($state['fila'], $state['numero'])
                                                        ? "{$state['fila']}{$state['numero']}"
                                                        : 'Novo Assento'
                                                ),
                                        ])
                                        ->columns(2)
                                        ->collapsed()
                                        ->itemLabel(fn(array $state): ?string => $state['nome'] ?? 'Nova Sala'),
                                ]),
                        ])
                            ->skippable()
                    ])
                    ->columnSpanFull()
            ]);
    }

    /**
     * Gera automaticamente os assentos com base nas fileiras e colunas.
     * Respeita a capacidade máxima da sala.
     */
    protected static function gerarAssentos(Set $set, Get $get, int $fileiras, int $colunas): void
    {
        $capacidade = $get('capacidade') ?? 0;
        $totalDesejado = $fileiras * $colunas;

        if ($totalDesejado > $capacidade && $capacidade > 0) {
            \Filament\Notifications\Notification::make()
                ->title('Capacidade excedida')
                ->body("Você tentou criar {$totalDesejado} assentos, mas a capacidade máxima é {$capacidade}.")
                ->danger()
                ->send();

            $totalDesejado = $capacidade;
        }

        $assentos = [];
        $letras = range('A', 'Z');
        $contador = 0;

        for ($i = 0; $i < $fileiras && $contador < $totalDesejado; $i++) {
            $letra = $letras[$i] ?? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(1));
            for ($j = 1; $j <= $colunas && $contador < $totalDesejado; $j++) {
                $assentos[] = [
                    'fila' => $letra,
                    'numero' => $j,
                    'disponivel' => true,
                ];
                $contador++;
            }
        }

        $set('assentos', $assentos);
    }
}
