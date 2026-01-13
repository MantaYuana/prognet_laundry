<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('promo_id')->nullable()->after('staff_id')->constrained('promos')->nullOnDelete();
            $table->string('promo_code')->nullable()->after('promo_id');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('promo_code');
            $table->unsignedBigInteger('subtotal')->default(0)->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['promo_id']);
            $table->dropColumn(['promo_id', 'promo_code', 'discount_amount', 'subtotal']);
        });
    }
};
