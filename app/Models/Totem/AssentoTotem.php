<?php

namespace App\Models\Totem;

use App\Models\Totem\TipoAssento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssentoTotem extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.assento';

    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    
    protected $fillable = [
        'sala_id',
        'tipo_assento_id',
        'fileira',
        'coluna',
        'ativo',
    ];
    
    protected $casts = [
        'sala_id' => 'integer',
        'tipo_assento_id' => 'integer',
        'fileira' => 'string',
        'coluna' => 'integer',
        'ativo' => 'boolean',
        'criado_em' => 'datetime',
        'atualizado_em' => 'datetime',
    ];

    public function sala(): BelongsTo
    {
        return $this->belongsTo(SalaTotem::class, 'sala_id');
    }

    public function tipoAssento(): BelongsTo
    {
        return $this->belongsTo(TipoAssento::class, 'tipo_assento_id');
    }
}
