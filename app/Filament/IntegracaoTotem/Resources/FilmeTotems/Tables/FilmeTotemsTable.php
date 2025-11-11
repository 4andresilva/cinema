<?php

namespace App\Filament\IntegracaoTotem\Resources\FilmeTotems\Tables;

use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class FilmeTotemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make()
                    ->columns(2)
                    ->schema([
                        ImageColumn::make('capa_url')
                            ->imageHeight('200px')
                            ->extraAttributes([
                                'style' => 'border-radius: 20px; object-fit: cover; flex-shrink: 1',
                            ])
                            ->tooltip(function ($record) {
                                if (!estaEmCartaz($record)) {
                                    return null;
                                }
                                $inicio = Carbon::parse($record->data_inicio_cartaz)->format('d/m/Y');
                                $fim = Carbon::parse($record->data_fim_cartaz)->format('d/m/Y');
                                return "Em cartaz de {$inicio} até {$fim}";
                            }),
                        Stack::make([
                            Split::make([
                                TextColumn::make('classificacao_indicativa_id')
                                    ->formatStateUsing(function ($record) {
                                        $classificacao = $record->classificacao->nome;
                                        $genero = $record->generos->first()?->nome ?? "";
                                        $cores = [
                                            'Livre' => '#008000',
                                            'A10' => '#0066CC',
                                            'A12' => '#FFCC00',
                                            'A14' => '#FF6600',
                                            'A16' => '#FF0000',
                                            'A18' => '#000000',
                                        ];
                                        $cor = $cores[$classificacao] ?? '';
                                        $labels = [
                                            'Livre' => 'L',
                                            'A10' => '+10',
                                            'A12' => '+12',
                                            'A14' => '+14',
                                            'A16' => '+16',
                                            'A18' => '+18',
                                        ];
                                        $label = $labels[$classificacao] ?? '';
                                        return new HtmlString(
                                            '<span style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 2px; display: flex; align-items: center; width: fit-content;">
                                                <div style="width: 25px; height: 25px; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; background-color: ' . $cor . '; color: white;">
                                                    ' . $label . '
                                                </div>
                                                <p style="margin-left: 8px; font-size: 12px;">
                                                    ' . $genero . '
                                                </p>
                                            </span>'
                                        );
                                    })
                                    ->html(),
                                TextColumn::make('data_inicio_cartaz')
                                    ->badge()
                                    ->color('warning')
                                    ->getStateUsing(fn($record) => estaEmCartaz($record) ? 'Em cartaz' : null),
                            ]),
                            TextColumn::make('titulo')
                                ->weight(FontWeight::Bold)
                                ->size('lg')
                                ->limit(25),
                            TextColumn::make('descricao')
                                ->limit(100)
                                ->wrap(),
                        ])
                        ->space(2)
                        ->extraAttributes([
                            'style' => 'flex-grow: 1;',
                        ]),
                    ])
                    ->extraAttributes([
                        'class' => 'items-start gap-4',
                        'style' => 'align-items: flex-start;',
                    ]),
            ])
            ->filters([
                Filter::make('titulo')
                    ->form([
                        TextInput::make('titulo')
                            ->placeholder('Buscar por título...')
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder =>
                        $query->when(
                            $data['titulo'] ?? null,
                            fn(Builder $query, $titulo): Builder =>
                            $query->where('titulo', 'ilike', "%{$titulo}%")
                        )
                    ),
                SelectFilter::make('generos')
                    ->label('Gêneros')
                    ->relationship('generos', 'nome')
                    ->multiple(),
                Filter::make('data_inicio_cartaz')
                    ->schema([
                        Select::make('status')
                            ->label('Em cartaz')
                            ->options([
                                'em_cartaz' => 'Sim (em cartaz)',
                                'nao_em_cartaz' => 'Não (fora do cartaz)',
                            ])
                            ->placeholder('Todos')
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder =>
                        $query->when(
                            $data['status'] ?? null,
                            fn(Builder $query, $status): Builder =>
                            match ($status) {
                                'em_cartaz' => $query->whereRaw(
                                    'data_inicio_cartaz <= CURRENT_DATE AND data_fim_cartaz >= CURRENT_DATE'
                                ),
                                'nao_em_cartaz' => $query->whereRaw(
                                    'data_inicio_cartaz > CURRENT_DATE OR data_fim_cartaz < CURRENT_DATE'
                                ),
                                default => $query
                            }
                        )
                    ),
            ])
            ->contentGrid(['md' => 2, 'xl' => 3])
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderByRaw(' 
                        CASE 
                            WHEN 
                                data_inicio_cartaz <= CURRENT_DATE AND 
                                data_fim_cartaz >= CURRENT_DATE 
                            THEN 0 
                            ELSE 1 
                        END 
                    ')
                    ->orderBy('titulo');
            });
    }
}

function estaEmCartaz($record): bool
{
    if (!$record || !$record->data_inicio_cartaz || !$record->data_fim_cartaz) {
        return false;
    }

    $agora = Carbon::now();
    $inicio = Carbon::parse($record->data_inicio_cartaz);
    $fim = Carbon::parse($record->data_fim_cartaz);

    return $agora->betweenIncluded($inicio, $fim);
}
