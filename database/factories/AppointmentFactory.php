<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student' => 9999,
            'client' => self::factoryForModel(User::class),
            'date' => fake()->dateTimeBetween('now', '+2 month'),
            'time' => fake()->time(),
            'location' => fake()->address(),
            'service_id' => fake()->numberBetween(1, 9),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
