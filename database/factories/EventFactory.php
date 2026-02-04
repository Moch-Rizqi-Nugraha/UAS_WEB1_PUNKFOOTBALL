<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'event_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'location' => $this->faker->address(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'completed']),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'max_participants' => $this->faker->numberBetween(10, 100),
            'current_participants' => $this->faker->numberBetween(0, 10),
            'category' => $this->faker->randomElement(['turnamen', 'pelatihan', 'friendly_match']),
            'poster' => null,
        ];
    }
}
