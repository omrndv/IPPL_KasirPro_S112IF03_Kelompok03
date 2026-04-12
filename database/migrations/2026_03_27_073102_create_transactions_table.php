<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique(); // Contoh: INV-20260327-001
            $table->integer('subtotal');
            $table->integer('tax'); // Pajak (misal 10%)
            $table->integer('grand_total');
            $table->integer('pay_amount')->default(0); // Uang yang dibayar pelanggan
            $table->integer('return_amount')->default(0); // Kembalian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
