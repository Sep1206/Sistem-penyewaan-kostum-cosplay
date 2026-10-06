<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_schedule_id')->constrained('rental_schedules')->cascadeOnDelete();
            // salah satu terisi: kostum ATAU aksesoris
            $table->foreignId('costume_id')->nullable()->constrained('costumes')->cascadeOnDelete();
            $table->foreignId('accessory_id')->nullable()->constrained('accessories')->cascadeOnDelete();
            $table->unsignedInteger('jumlah');
            $table->decimal('harga_satuan', 12, 2); // harga per hari saat disewa
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
