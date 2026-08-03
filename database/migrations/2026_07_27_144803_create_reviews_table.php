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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id('id_ulasan');

        // Order yang diberi ulasan
        $table->foreignId('id_order')
              ->constrained('orders', 'id_order')
              ->cascadeOnDelete();

        // Rating pelanggan
        $table->tinyInteger('rating');

        // Ulasan pelanggan
        $table->text('ulasan')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('reviews');
}
};
