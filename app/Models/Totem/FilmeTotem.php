<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilmeTotem extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.filme';

    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'classificacao_indicativa_id',
        'titulo',
        'descricao',
        'duracao_em_minutos',
        'trailer_url',
        'capa_url',
        'banner_url',
        'direcao',
        'elenco',
        'data_lancamento',
        'data_inicio_cartaz',
        'data_fim_cartaz',
        'ativo',
    ];

    protected $casts = [
        'classificacao_indicativa_id' => 'integer',
        'duracao_em_minutos' => 'integer',
        'data_lancamento' => 'datetime',
        'data_inicio_cartaz' => 'datetime',
        'data_fim_cartaz' => 'datetime',
        'ativo' => 'boolean',
    ];

    public function classificacao(): BelongsTo
    {
        return $this->belongsTo(ClassificacaoIndicativa::class, 'classificacao_indicativa_id', 'id');
    }

    public function sessoes(): HasMany
    {
        return $this->hasMany(SessaoTotem::class, 'filme_id');
    }

    public function generos(): BelongsToMany
    {
        return $this->belongsToMany(
            Genero::class,
            'filme_genero',
            'filme_id',
            'genero_id'
        )
        ->withPivot('criado_em', 'atualizado_em');
    }

    public function sala(): BelongsTo
    {
        return $this->belongsTo(SalaTotem::class, 'sala_id');
    }
}
