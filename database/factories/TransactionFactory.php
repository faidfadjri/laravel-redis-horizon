<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'    => User::factory(),
            'amount'     => $this->faker->randomFloat(2, 1, 1000),
            'status'     => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
