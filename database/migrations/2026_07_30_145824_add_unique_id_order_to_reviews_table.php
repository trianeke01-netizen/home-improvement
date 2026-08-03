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
    Schema::table('reviews', function (Blueprint $table) {
        $table->unique('id_order'); // 1 order hanya boleh 1 review
    });
}

public function down(): void
{
    Schema::table('reviews', function (Blueprint $table) {
        $table->dropUnique(['id_order']);
    });
}
};
