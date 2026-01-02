<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasColumn('order_details', 'item_price')) {
            Schema::table('order_details', function (Blueprint $table) {
                $table->unsignedBigInteger('item_price')->default(0)->after('quantity');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        if (Schema::hasColumn('order_details', 'unit_price')) {
            Schema::table('order_details', function (Blueprint $table) {
                $table->dropColumn('unit_price');
            });
        }
    }
};
