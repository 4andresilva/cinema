<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assento extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'assentos';

    protected $fillable = [
        "id",
        "sala_id",
        "fila",
        "numero",
        "disponivel"
    ];

    protected $casts = [
        "fila" => "string",
        "numero" => "integer",
        "disponivel" => "boolean"
    ];

    public function sala(): BelongsTo
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }
}
