<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Order ID yang dikirim ke Midtrans (sama dengan invoice_no)
            $table->string('midtrans_order_id')->nullable()->after('invoice_no');
            // Snap token untuk buka popup Midtrans
            $table->text('midtrans_snap_token')->nullable()->after('midtrans_order_id');
            // Status pembayaran: cash langsung 'paid', midtrans mulai 'pending'
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled'])
                  ->default('paid')
                  ->after('midtrans_snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['midtrans_order_id', 'midtrans_snap_token', 'payment_status']);
        });
    }
};
