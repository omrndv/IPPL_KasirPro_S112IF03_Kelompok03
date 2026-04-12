<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // Bahan Kering, Bahan Basah, Packaging

            // Menggunakan decimal agar bisa menyimpan nilai seperti 1.5 (Kg/Liter)
            $table->decimal('stock', 10, 2)->default(0);
            $table->decimal('min_stock', 10, 2)->default(0); // Batas peringatan kritis

            $table->string('unit'); // Kg, Liter, Pcs, Box
            $table->integer('price_per_unit')->default(0); // HPP per satuan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
