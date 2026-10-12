<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_payment');

            // Relasi ke pesanan
            $table->foreignId('id_order')
                ->constrained('orders', 'id_order')
                ->cascadeOnDelete();

            // ID transaksi yang dibuat oleh sistem untuk Midtrans
            $table->string('order_id_midtrans')->unique();

            // Transaction ID yang diberikan Midtrans
            $table->string('transaction_id')->nullable();

            // Nominal pembayaran
            $table->decimal('gross_amount', 12, 2);

            // Metode pembayaran, untuk TA saat ini QRIS
            $table->string('payment_method')->nullable();

            // Status transaksi dari Midtrans
            $table->string('transaction_status')->default('pending');

            // Waktu pembayaran berhasil
            $table->timestamp('paid_at')->nullable();

            // Status penyaluran dana teknisi
            $table->enum('payout_status', [
                'ditahan',
                'siap_disalurkan',
                'disalurkan'
            ])->default('ditahan');

            // Waktu dana dinyatakan disalurkan
            $table->timestamp('released_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};