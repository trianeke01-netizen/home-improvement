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
    public function notifications(): HasMany
    {
        return $this->hasMany(AppNotification::class, 'id_user', 'id_user')->latest();
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class, 'id_user', 'id_user')->where('is_read', false)->latest();
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

    public function getWhatsappNumberAttribute(): ?string
    {
        if (!$this->no_hp) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $this->no_hp);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    public function getWhatsappLinkWithMessage(string $message = ''): string
    {
        $waNum = $this->whatsapp_number;
        if (!$waNum) {
            return '#';
        }

        return 'https://wa.me/' . $waNum . ($message ? '?text=' . urlencode($message) : '');
    }

    public function getAverageRatingAttribute(): float
    {
        if (!$this->isTeknisi()) {
            return 0.0;
        }

        $avg = Review::whereHas('order', function ($query) {
            $query->where('id_teknisi', $this->id_user);
        })->avg('rating');

        return round((float) ($avg ?? 0.0), 1);
    }
}