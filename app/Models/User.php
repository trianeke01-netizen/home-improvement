<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'no_hp',
        'role_user',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function profileTeknisi(): HasOne
    {
        return $this->hasOne(ProfileTeknisi::class, 'id_user', 'id_user');
    }

    public function ordersSebagaiPelanggan(): HasMany
    {
        return $this->hasMany(Order::class, 'id_pelanggan', 'id_user');
    }

    public function ordersSebagaiTeknisi(): HasMany
    {
        return $this->hasMany(Order::class, 'id_teknisi', 'id_user');
    }
    public function isAdmin(): bool
    {
    return $this->role_user === 'admin';
    }

    public function isPelanggan(): bool
    {
    return $this->role_user === 'pelanggan';
    }

    public function isTeknisi(): bool
    {
    return $this->role_user === 'teknisi';
    }
}