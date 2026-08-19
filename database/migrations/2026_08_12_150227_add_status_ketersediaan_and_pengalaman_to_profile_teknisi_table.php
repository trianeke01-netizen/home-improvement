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
        Schema::table('profile_teknisi', function (Blueprint $table) {
            if (!Schema::hasColumn('profile_teknisi', 'status_ketersediaan')) {
                $table->enum('status_ketersediaan', ['Tersedia', 'Sibuk'])->default('Tersedia')->after('status_verifikasi');
            }
            if (!Schema::hasColumn('profile_teknisi', 'pengalaman')) {
                $table->text('pengalaman')->nullable()->after('status_ketersediaan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_teknisi', function (Blueprint $table) {
            $table->dropColumn(['status_ketersediaan', 'pengalaman']);
        });
    }
};
