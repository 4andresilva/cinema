<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassificacaoIndicativa extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.classificacao_indicativa';
    public $timestamps = true;

    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
        'ativo',
        'criado_em',
        'atualizado_em',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'criado_em' => 'datetime',
        'atualizado_em' => 'datetime',
    ];
    
    public function filmes(): HasMany
    {
        return $this->hasMany(FilmeTotem::class, 'classificacao_indicativa_id');
    }
}
