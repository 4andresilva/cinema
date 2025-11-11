<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;

class SessaoAssento extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.sessao_assento';
    
    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'id',
        'sessao_id',
        'assento_id'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}