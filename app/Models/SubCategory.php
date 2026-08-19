<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    /**
     * Nama tabel
     */
    protected $table = 'sub_categories';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_sub_kategori';

    /**
     * Primary key menggunakan auto increment
     */
    public $incrementing = true;

    /**
     * Tipe primary key
     */
    protected $keyType = 'int';

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'id_kategori',
        'nama_sub_kategori',
        'harga_per_unit',
    ];


    /**
     * =========================================================
     * RELASI KE CATEGORY
     * =========================================================
     *
     * Satu subkategori dimiliki oleh satu kategori.
     *
     * Contoh:
     *
     * Kelistrikan
     *      └── Instalasi Saklar
     *
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'id_kategori',
            'id_kategori'
        );
    }


    /**
     * =========================================================
     * RELASI KE ORDER
     * =========================================================
     *
     * Satu subkategori dapat digunakan oleh banyak order.
     *
     * Contoh:
     *
     * Instalasi Saklar
     *      ├── Order 1
     *      ├── Order 2
     *      ├── Order 3
     *      └── dst.
     *
     */

    public function orders(): HasMany
    {
        return $this->hasMany(
            Order::class,
            'id_sub_kategori',
            'id_sub_kategori'
        );
    }
}