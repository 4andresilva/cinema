<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'clientes';

    protected $fillable = [
        "nome",
        "email",
        "telefone"
    ];

    protected $casts = [
        "nome" => "string",
        "email" => "string",
        "telefone" => "string"
    ];

    
}
