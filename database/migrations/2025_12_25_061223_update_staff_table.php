<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('address')->nullable()->after('title');
            $table->foreignId('user_id')->nullable()->after('outlet_id')->constrained()->nullOnDelete();
            $table->dropColumn(['name', 'email']);
        });
        Schema::rename('staff', 'staffs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::rename('staffs', 'staff');
        Schema::table('staff', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['title', 'address']);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
        });
    }
};
