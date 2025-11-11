<?php

namespace App\Models\Totem;

use App\Models\Totem\AssentoTotem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaTotem extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.sala';

    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'sala_id',
        'tipo_sala_id',
        'numero',
        'quantidade_fileiras',
        'quantidade_assentos_por_fileira',
        'ativo',
    ];

    protected $casts = [
        'tipo_sala_id' => 'integer',
        'numero' => 'integer',
        'quantidade_fileiras' => 'integer',
        'quantidade_assentos_por_fileira' => 'integer',
        'ativo' => 'boolean',
    ];

    public function tipoSala(): BelongsTo
    {
        return $this->belongsTo(TipoSala::class, 'tipo_sala_id', 'id');
    }

    public function tipoSessao(): BelongsTo
    {
        return $this->belongsTo(TipoSessao::class, 'tipo_sessao_id', 'id');
    }

    public function tipoIdioma(): BelongsTo
    {
        return $this->belongsTo(TipoIdioma::class, 'tipo_idioma_id', 'id');
    }

    public function assentos(): HasMany
    {
        return $this->hasMany(AssentoTotem::class, 'sala_id', 'id');
    }

    public function sessoes(): HasMany
    {
        return $this->hasMany(SessaoTotem::class, 'sala_id', 'id');
    }
}
