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
    Schema::create('profile_teknisi', function (Blueprint $table) {
        $table->id('id_profile');

        $table->foreignId('id_user')
              ->constrained('users', 'id_user')
              ->cascadeOnDelete();

        $table->foreignId('id_kategori')
              ->constrained('categories', 'id_kategori')
              ->cascadeOnDelete();

        $table->foreignId('id_sub_kategori')
              ->constrained('sub_categories', 'id_sub_kategori')
              ->cascadeOnDelete();

        $table->string('ktp');
        $table->string('foto_diri');
        $table->string('portofolio')->nullable();

        $table->enum('status_verifikasi', [
            'Menunggu',
            'Disetujui',
            'Ditolak'
        ])->default('Menunggu');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('profile_teknisi');
}
};
