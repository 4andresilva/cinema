<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Totem\Ingresso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'documento',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ingressos()
    {
        return $this->hasMany(Ingresso::class, 'documento_responsavel', 'documento');
    }

    public function setDocumentoAttribute($value)
    {
        $this->attributes['documento'] = preg_replace('/\D/', '', $value);
    }

    public function getDocumentoAttribute($value)
    {
        return $value;
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->role = 'cliente';
        });
    }
}
