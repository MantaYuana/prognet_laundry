<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Owner;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name'   => fake()->company(),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'owner_id' => Owner::factory(),
        ];
    }
}
