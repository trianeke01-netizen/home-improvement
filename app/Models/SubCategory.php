<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubCategory extends Model
{
    protected $primaryKey = 'id_sub_kategori';

    protected $fillable = [
        'id_kategori',
        'nama_sub_kategori',
        'harga_per_unit',
        'deskripsi',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }
}