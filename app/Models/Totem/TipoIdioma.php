<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipoIdioma extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.tipo_idioma';
    
    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'criado_em' => 'datetime',
        'atualizado_em' => 'datetime',
    ];

    public function sessoes(): BelongsToMany
    {
        return $this->belongsToMany(
            SessaoTotem::class,
            'sessao_id'
        )
        ->withTimestamps();
    }
}