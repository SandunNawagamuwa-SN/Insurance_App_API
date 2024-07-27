<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InsurancePolicy>
 */
class InsurancePolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'policy_number' => fake()->unique()->e164PhoneNumber(),
            'holder_name' => fake()->name(),
            'type_of_insurance' => fake()->randomElement(['TERM', 'WHOLE', 'UNIVERSAL']),
            'coverage_amount' => fake()->randomFloat(2, 100, 10000),
        ];
    }
}
