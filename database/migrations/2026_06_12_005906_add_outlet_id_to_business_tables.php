<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'outlet_id')) {
                $table->foreignId('outlet_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('outlets')
                    ->nullOnDelete();
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'outlet_id')) {
                $table->foreignId('outlet_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('outlets')
                    ->nullOnDelete();
            }
        });

        Schema::table('raw_materials', function (Blueprint $table) {
            if (!Schema::hasColumn('raw_materials', 'outlet_id')) {
                $table->foreignId('outlet_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('outlets')
                    ->nullOnDelete();
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'outlet_id')) {
                $table->foreignId('outlet_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('outlets')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'outlet_id')) {
                $table->dropForeign(['outlet_id']);
                $table->dropColumn('outlet_id');
            }
        });

        Schema::table('raw_materials', function (Blueprint $table) {
            if (Schema::hasColumn('raw_materials', 'outlet_id')) {
                $table->dropForeign(['outlet_id']);
                $table->dropColumn('outlet_id');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'outlet_id')) {
                $table->dropForeign(['outlet_id']);
                $table->dropColumn('outlet_id');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'outlet_id')) {
                $table->dropForeign(['outlet_id']);
                $table->dropColumn('outlet_id');
            }
        });
    }
};