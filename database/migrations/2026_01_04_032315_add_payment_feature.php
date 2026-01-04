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
            $table->string('payment_method')->nullable()->after('total');
            $table->string('payment_status')->default('unpaid')->after('payment_method');
            $table->string('payment_proof_path')->nullable()->after('payment_status');
            $table->timestamp('paid_at')->nullable()->after('payment_proof_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_proof_path');
            $table->dropColumn('paid_at');
        });
    }
};
