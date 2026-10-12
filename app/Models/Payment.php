<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'id_order',
        'order_id_midtrans',
        'transaction_id',
        'gross_amount',
        'payment_method',
        'transaction_status',
        'paid_at',
        'payout_status',
        'released_at',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    /**
     * Payment milik satu Order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'id_order',
            'id_order'
        );
    }
}