<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_order',
        'rating',
        'ulasan',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
}