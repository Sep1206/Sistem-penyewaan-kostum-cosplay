<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costumes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kostum');
            $table->string('karakter');
            $table->string('kategori');
            $table->string('ukuran');
            $table->decimal('harga_sewa', 12, 2);
            $table->string('kondisi');
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costumes');
    }
};
