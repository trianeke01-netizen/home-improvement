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
        Schema::create('orders', function (Blueprint $table) {

    $table->id('id_order');

    $table->foreignId('id_pelanggan')
          ->constrained('users','id_user')
          ->cascadeOnDelete();

    $table->foreignId('id_teknisi')
          ->nullable()
          ->constrained('users','id_user')
          ->nullOnDelete();

    $table->foreignId('id_sub_kategori')
          ->constrained('sub_categories','id_sub_kategori')
          ->cascadeOnDelete();

    $table->integer('jumlah_unit');

    $table->decimal('harga_per_unit',12,2);

    $table->text('deskripsi_kerusakan');

    $table->string('foto_kerusakan')->nullable();

    $table->text('alamat');

    $table->dateTime('jadwal');

    $table->enum('status',[
        'Menunggu',
        'Diproses',
        'Selesai',
        'Dibatalkan'
    ])->default('Menunggu');

    $table->decimal('total_harga',12,2);

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};