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
        'foto_bukti',
        'alamat',
        'jadwal',
        'status',
        'waktu_diterima',
        'total_harga',
        'metode_pembayaran',
        'alasan_batal_teknisi',
        'catatan_batal_teknisi',
        'foto_kendala',
        'waktu_pengajuan_batal',
        'excluded_teknisi_ids',
    ];

    protected $casts = [
        'waktu_diterima' => 'datetime',
        'waktu_pengajuan_batal' => 'datetime',
        'excluded_teknisi_ids' => 'array',
    ];

    /**
     * Relasi ke pelanggan.
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_pelanggan',
            'id_user'
        );
    }

    /**
     * Relasi ke teknisi.
     */
    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_teknisi',
            'id_user'
        );
    }

    /**
     * Relasi ke sub kategori layanan.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(
            SubCategory::class,
            'id_sub_kategori',
            'id_sub_kategori'
        );
    }

    /**
     * Relasi ke review.
     */
    public function review(): HasOne
    {
        return $this->hasOne(
            Review::class,
            'id_order',
            'id_order'
        );
    }

    /**
     * Relasi ke pembayaran Midtrans.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(
            Payment::class,
            'id_order',
            'id_order'
        );
    }

    /**
     * Pengecekan dan pengalihan otomatis untuk order yang melewati batas waktu 1 jam.
     */
    public static function releaseExpiredOrders(): void
    {
        $expiredOrders = self::with(['teknisi', 'pelanggan'])
            ->where('status', 'Dikonfirmasi')
            ->whereNotNull('waktu_diterima')
            ->whereNull('waktu_pengajuan_batal')
            ->where('waktu_diterima', '<=', \Carbon\Carbon::now()->subMinutes(60))
            ->get();

        foreach ($expiredOrders as $order) {
            $oldTeknisiId = $order->id_teknisi;
            $oldTeknisiName = $order->teknisi->nama ?? 'Teknisi';

            $excluded = $order->excluded_teknisi_ids ?? [];
            if (!is_array($excluded)) {
                $excluded = [];
            }
            if ($oldTeknisiId && !in_array((int)$oldTeknisiId, array_map('intval', $excluded))) {
                $excluded[] = (int)$oldTeknisiId;
            }

            $order->update([
                'id_teknisi' => null,
                'status' => 'Menunggu',
                'waktu_diterima' => null,
                'excluded_teknisi_ids' => array_values(array_unique(array_map('intval', $excluded))),
            ]);

            // 1. Kirim Notifikasi ke Pelanggan
            if ($order->id_pelanggan) {
                AppNotification::send(
                    $order->id_pelanggan,
                    'Teknisi Dialihkan',
                    "Teknisi {$oldTeknisiName} tidak merespons dalam batas waktu 1 jam. Pesanan Anda #{$order->id_order} otomatis dialihkan untuk mencari teknisi pengganti.",
                    'order_dialihkan',
                    route('dashboard.detail-order', $order->id_order)
                );
            }

            // 2. Kirim Notifikasi ke Teknisi yang Lalai
            if ($oldTeknisiId) {
                AppNotification::send(
                    $oldTeknisiId,
                    'Batas Waktu Habis',
                    "Waktu 1 jam telah habis untuk pesanan #{$order->id_order}. Pesanan telah dialihkan ke teknisi lain.",
                    'order_expired',
                    route('dashboard.teknisi')
                );
            }
        }
    }
}