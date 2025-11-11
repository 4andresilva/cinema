<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pagamento extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.pagamento';
    
    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'id',
        'ingresso_id',
        'forma_pagamento_id',
        'valor_total',
        'ativo'
    ];

    protected $casts = [
        'valor_total' => 'decimal:2',
        'ativo' => 'boolean'
    
    ];

    public function ingresso(): BelongsTo
    {
        return $this->belongsTo(Ingresso::class, 'ingresso_id', 'id');
    }

    public function formaPagamento(): BelongsTo
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id', 'id');
    }

    public function cliente(): BelongsTo
    {
        // precisa relacionar com o campo documento_responsavel da model Ingresso
        return $this->belongsTo(Ingresso::class, 'documento_responsavel', 'ingresso_id');
    }
    
    
}
