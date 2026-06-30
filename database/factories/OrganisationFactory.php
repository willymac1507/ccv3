<?php

namespace Database\Factories;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Random\RandomException;

/**
 * @extends Factory<Organisation>
 */
class OrganisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        $addresses = Storage::json('NR postcodes.json');
        $entry = random_int(0, count($addresses['features']) - 1);
        $address = $addresses['features'][$entry];

        return [
            'name' => fake()->company(),
            'admin_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake('en_GB')->unique()->phoneNumber(),
            'address1' => fake('en_GB')->streetAddress(),
            'city' => fake('en_GB')->city(),
            'county' => fake('en_GB')->county(),
            'postcode' => $address['properties']['name'],
            'lat' => $address['geometry']['coordinates'][1],
            'lng' => $address['geometry']['coordinates'][0],
        ];
    }
}
