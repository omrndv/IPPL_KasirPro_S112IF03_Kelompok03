<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel categories (Jika kategori dihapus, produk tidak ikut terhapus otomatis/restrict)
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');

            $table->string('sku')->unique()->nullable(); // Barcode/SKU (Opsional)
            $table->string('name'); // Nama Barang/Jasa
            $table->string('unit')->default('Pcs'); // Pcs, Kg, Jam, Porsi, dll.

            $table->integer('cost_price')->default(0); // Harga Modal Dasar (HPP)
            $table->integer('selling_price')->default(0); // Harga Jual

            $table->integer('stock')->default(0); // Sisa Stok
            $table->boolean('is_stock_tracked')->default(true); // Jasa (False), Barang Fisik (True)

            $table->string('image')->nullable(); // Foto Produk
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
