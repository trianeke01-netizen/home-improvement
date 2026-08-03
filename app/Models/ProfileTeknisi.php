<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileTeknisi extends Model
{
    protected $table = 'profile_teknisi';

    protected $primaryKey = 'id_profile';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'id_kategori',
        'id_sub_kategori',
        'ktp',
        'foto_diri',
        'portofolio',
        'status_verifikasi',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'id_sub_kategori', 'id_sub_kategori');
    }
}