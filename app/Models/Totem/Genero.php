<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genero extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.genero';
    
    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function filmes(): BelongsToMany
    {
        return $this->belongsToMany(
            FilmeTotem::class,
            'filme_genero',
            'genero_id',
            'filme_id'
        )
        ->withTimestamps();
    }
}