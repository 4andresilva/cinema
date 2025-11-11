<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoSala extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.tipo_sala';

    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
        'ativo'
    ];

    protected $casts = [
        'nome' => 'string',
        'ativo' => 'boolean'
    ];

    public function salas(): HasMany
    {
        return $this->hasMany(SalaTotem::class, 'tipo_sala_id');
    }
}
