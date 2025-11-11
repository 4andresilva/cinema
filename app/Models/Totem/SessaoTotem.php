<?php

namespace App\Models\Totem;

use Illuminate\Database\Eloquent\Model;

class SessaoTotem extends Model
{
    protected $connection = 'pgsql_totem';
    protected $table = 'public.sessao';
    public $timestamps = true;
    
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'filme_id',
        'sala_id',
        'tipo_sessao_id',
        'tipo_idioma_id',
        'inicio',
        'fim',
        'preco'
    ];

    public function filme()
    {
        return $this->belongsTo(FilmeTotem::class, 'filme_id', 'id');
    }

    public function sala()
    {
        return $this->belongsTo(SalaTotem::class, 'sala_id');
    }

    public function tipoSessao()
    {
        return $this->belongsTo(TipoSessao::class, 'tipo_sessao_id', 'id');
    }

    public function tipoIdioma()
    {
        return $this->belongsTo(TipoIdioma::class, 'tipo_idioma_id', 'id');
    }

    public function sessoesAssentos() 
    {
        return $this->hasMany(SessaoAssento::class, 'sessao_id');
    }
}
