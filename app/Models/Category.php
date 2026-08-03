<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];
    public function subCategories(): HasMany
{
    return $this->hasMany(SubCategory::class, 'id_kategori', 'id_kategori');
}
}