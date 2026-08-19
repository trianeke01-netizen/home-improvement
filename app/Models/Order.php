<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $primaryKey = 'id_order';
    
    protected $fillable = [
        'id_pelanggan',
        'id_teknisi',
        'id_sub_kategori',
        'jumlah_unit',
        'harga_per_unit',
        'deskripsi_kerusakan',
        'foto_kerusakan',
        'alamat',
        'jadwal',
        'status',
        'total_harga',
        'metode_pembayaran',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_pelanggan',
            'id_user'
        );
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_teknisi',
            'id_user'
        );
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(
            SubCategory::class,
            'id_sub_kategori',
            'id_sub_kategori'
        );
    }

    public function review(): HasOne
    {
        return $this->hasOne(
            Review::class,
            'id_order',
            'id_order'
        );
    }
}