<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Sala;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'cinemas';

    protected $fillable = [
        "nome",
        "endereco",
        "telefone",
        "disponivel"
    ];

    protected $casts = [
        "nome" => "string",
        "endereco" => "string",
        "telefone" => "string",
        "disponivel" => "boolean"
    ];


    public function salas(): HasMany {
        return $this->hasMany(Sala::class, 'cinema_id');
    }

    public function totalSalas(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->salas()->count(),
        );
    }
}
