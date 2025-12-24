<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Outlet;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        User::firstOrCreate(
            [
                'email' => 'Admin001@prognetlaravel.com',
                'name' => 'Admin',
                'password' => Hash::make("Admin123"),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        )->assignRole($adminRole);

        User::firstOrCreate(
            [
                'email' => 'Owner001@prognetlaravel.com',
                'name' => 'Owner',
                'password' => Hash::make("Owner123"),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        )->assignRole($ownerRole);

        User::factory(10)->create();
        Outlet::factory(10)->create();
    }
}
