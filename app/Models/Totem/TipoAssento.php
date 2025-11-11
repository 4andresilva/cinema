<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoAssento extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.tipo_assento';

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

    public function assentos(): HasMany
    {
        return $this->hasMany(AssentoTotem::class, 'tipo_assento_id');
    }
}