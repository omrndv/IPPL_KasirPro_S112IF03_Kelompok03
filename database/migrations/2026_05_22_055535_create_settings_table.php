<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
                'key' => 'store_name',
                'value' => 'KasirPro Coffee & Eatery',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'store_phone',
                'value' => '0812-3456-7890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'store_address',
                'value' => 'Jl. DI Panjaitan No. 128, Purwokerto Selatan, Kab. Banyumas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tax_enabled',
                'value' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tax_rate',
                'value' => '10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'receipt_footer',
                'value' => "Terima kasih telah berkunjung!\nBarang yang sudah dibeli tidak dapat ditukar/dikembalikan.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};