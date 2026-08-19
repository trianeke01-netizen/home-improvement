<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    protected $table = 'app_notifications';
    protected $primaryKey = 'id_notification';

    protected $fillable = [
        'id_user',
        'judul',
        'pesan',
        'tipe',
        'url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Helper method to send notification quickly
     */
    public static function send(int $userId, string $judul, string $pesan, string $tipe = 'info', ?string $url = null): self
    {
        return self::create([
            'id_user' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
            'url'     => $url,
            'is_read' => false,
        ]);
    }
}
