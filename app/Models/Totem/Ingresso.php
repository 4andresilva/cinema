<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingresso extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.ingresso';
    
    public $timestamps = true;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'documento_responsavel',
        'ativo'
    ];

    protected $casts = [
        'documento_responsavel' => 'string',
        'ativo' => 'boolean'
    ];
    
    public function pagamento(): HasMany
    {
        return $this->hasMany(Pagamento::class, 'ingresso_id', 'id');
    }

}
