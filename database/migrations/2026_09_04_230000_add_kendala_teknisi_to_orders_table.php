<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum status agar mendukung VARCHAR jika perlu
        try {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'Menunggu'");
        } catch (\Throwable $e) {
            // Abaikan jika bukan MySQL
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'alasan_batal_teknisi')) {
                $table->string('alasan_batal_teknisi')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'catatan_batal_teknisi')) {
                $table->text('catatan_batal_teknisi')->nullable()->after('alasan_batal_teknisi');
            }
            if (!Schema::hasColumn('orders', 'foto_kendala')) {
                $table->string('foto_kendala')->nullable()->after('catatan_batal_teknisi');
            }
            if (!Schema::hasColumn('orders', 'waktu_pengajuan_batal')) {
                $table->timestamp('waktu_pengajuan_batal')->nullable()->after('foto_kendala');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'alasan_batal_teknisi',
                'catatan_batal_teknisi',
                'foto_kendala',
                'waktu_pengajuan_batal',
            ]);
        });
    }
};
