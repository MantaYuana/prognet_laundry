<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('outlets', function (Blueprint $table) {
            $table->foreignId('owner_id')
                ->nullable()
                ->after('phone_number')
                ->constrained('owners')
                ->nullOnDelete();
        });

        DB::transaction(function () {
            $usersWithOutlets = DB::table('outlets')
                ->select('user_id')
                ->whereNotNull('user_id')
                ->distinct()
                ->get();

            foreach ($usersWithOutlets as $row) {
                $ownerId = DB::table('owners')->insertGetId([
                    'user_id' => $row->user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('outlets')
                    ->where('user_id', $row->user_id)
                    ->update(['owner_id' => $ownerId]);
            }
        });

        Schema::table('outlets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('outlets', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('phone_number')
                ->constrained('users')
                ->nullOnDelete();
        });

        DB::transaction(function () {
            $outlets = DB::table('outlets')->select('id', 'owner_id')->get();

            foreach ($outlets as $outlet) {
                $userId = DB::table('owners')->where('id', $outlet->owner_id)->value('user_id');
                if ($userId) {
                    DB::table('outlets')
                        ->where('id', $outlet->id)
                        ->update(['user_id' => $userId]);
                }
            }
        });

        Schema::table('outlets', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
        });

        Schema::dropIfExists('owners');
    }
};
