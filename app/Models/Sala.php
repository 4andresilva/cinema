<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Cinema;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sala extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'salas';

    protected $fillable = [
        "nome",
        "capacidade",
        "tipo",
        "disponivel",
        "cinema_id"
    ];

    protected $casts = [
        "nome" => "string",
        "capacidade" => "integer",
        "tipo" => "string",
        "disponivel" => "boolean",
    ];

    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }

    public function assentos(): HasMany
    {
        return $this->hasMany(Assento::class, 'sala_id');
    }

    public function sessoes(): HasMany
    {
        return $this->hasMany(Sessao::class, 'sala_id');
    }
}
