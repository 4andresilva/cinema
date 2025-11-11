<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sessao extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'sessoes';

    protected $fillable = [
        "filme_id",
        "sala_id",
        "data_hora",
        "preco",
        "disponivel"
    ];

    protected $casts = [
        "data_hora" => "timestamp",
        "preco" => "decimal",
        "disponivel" => "boolean"
    ];

    public function filme(): BelongsTo
    {
        return $this->belongsTo(Filme::class, 'filme_id');
    }

    public function sala(): BelongsTo
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }
}
