<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profile_teknisi', function (Blueprint $table) {
            $table->foreignId('id_sub_kategori')->nullable()->change();
            $table->string('foto_diri')->nullable()->change();
            $table->string('ktp')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('profile_teknisi', function (Blueprint $table) {
            $table->foreignId('id_sub_kategori')->nullable(false)->change();
            $table->string('foto_diri')->nullable(false)->change();
            $table->string('ktp')->nullable(false)->change();
        });
    }
};