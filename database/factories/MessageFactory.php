<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender' => fake()->name(),
            'receiver' => fake()->name(),
            'body' => fake()->sentence(),
            'sent_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'read' => fake()->boolean(),
        ];
    }
}
