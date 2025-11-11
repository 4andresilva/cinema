<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filme extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'filmes';

    protected $fillable = [
        "titulo",
        "sinopse",
        "duracao_min",
        "genero",
        "classificacao",
        "poster"
    ];

    protected $casts = [
        "titulo" => "string",
        "sinopse" => "string",
        "duracao_min" => "integer",
        "genero" => "string",
        "classificacao" => "string",
        "poster" => "string"
    ];

    public function sessoes(): HasMany
    {
        return $this->hasMany(Sessao::class, 'filme_id');
    }

    public function sala(): HasMany
    {
        return $this->hasMany(Sala::class, 'sala_id');
    }
}
