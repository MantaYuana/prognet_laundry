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
        Schema::table('orders', function (Blueprint $table) {
            // Kita pakai pengecekan (!Schema::hasColumn) biar aman kalau dijalankan ulang
            
            if (!Schema::hasColumn('orders', 'promo_id')) {
                // Menambahkan kolom promo_id
                $table->foreignId('promo_id')->nullable()->after('staff_id')->constrained('promos')->nullOnDelete();
            }

            if (!Schema::hasColumn('orders', 'promo_code')) {
                $table->string('promo_code')->nullable()->after('promo_id');
            }

            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0)->after('promo_code');
            }

            // INI PENTING: Error terakhirmu bilang kolom 'subtotal' hilang juga
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('discount_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus foreign key dulu (wajib pakai array sintaks)
            $table->dropForeign(['promo_id']);
            // Baru hapus kolomnya
            $table->dropColumn(['promo_id', 'promo_code', 'discount_amount', 'subtotal']);
        });
    }
};