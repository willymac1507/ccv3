<?php

namespace Database\Factories;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organisation>
 */
class OrganisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'admin_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake('en_GB')->unique()->phoneNumber(),
            'address1' => fake('en_GB')->streetAddress(),
            'city' => fake('en_GB')->city(),
            'county' => fake('en_GB')->county(),
            'postcode' => fake('en_GB')->postcode(),
        ];
    }
}
