<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id_user');
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_teknisi', 'id_user');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'id_sub_kategori', 'id_sub_kategori');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'id_order', 'id_order');
    }
}