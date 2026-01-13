<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('promo_code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('value', 10, 2);
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_active')->default(true);
            $table->foreignId('outlet_id')->constrained('outlets')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['promo_code', 'outlet_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('promo');
    }
};
