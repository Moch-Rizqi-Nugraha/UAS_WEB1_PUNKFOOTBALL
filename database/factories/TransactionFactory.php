<?php

namespace Database\Factories;

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
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'transaction_type' => $this->faker->randomElement(['ticket', 'merchandise', 'registration']),
            'item_name' => $this->faker->sentence(2),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled', 'refunded']),
            'transaction_data' => json_encode(['test' => 'data']),
            'transaction_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'payment_method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'cash']),
            'reference_number' => $this->faker->unique()->numerify('REF#####'),
            'notes' => $this->faker->optional()->sentence(),
            'product_id' => null,
        ];
    }
}
