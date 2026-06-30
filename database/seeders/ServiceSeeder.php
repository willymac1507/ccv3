<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => "Gent's cut",
                'description' => 'Standard cut on short hair',
                'min_duration' => 2,
            ],
            [
                'name' => 'Long hair cut',
                'description' => 'Standard cut on long hair',
                'min_duration' => 3,
            ],
            [
                'name' => 'Beard trim',
                'description' => 'Trim beard using clipper, trimmer and scissors.svg',
                'min_duration' => 1,
            ],
            [
                'name' => 'Hair colour',
                'description' => 'Hair colour on short hair',
                'min_duration' => 4,
            ],
            [
                'name' => 'Highlights',
                'description' => 'Highlights on short hair using cap',
                'min_duration' => 4,
            ],
            [
                'name' => 'Wet shave',
                'description' => 'Wet shave using a razor and towels',
                'min_duration' => 2,
            ],
            [
                'name' => 'Perm short',
                'description' => 'Partial perm on short hair',
                'min_duration' => 4,
            ],
            [
                'name' => 'Perm long',
                'description' => 'Partial or full perm on long hair',
                'min_duration' => 6,
            ],
            [
                'name' => 'Shampoo short',
                'description' => 'Shampoo, condition and style on short hair',
                'min_duration' => 2,
            ],
        ];
        for ($i = 0; $i < 9; $i++) {
            Service::create([
                'name' => $services[$i]['name'],
                'description' => $services[$i]['description'],
                'min_duration' => $services[$i]['min_duration'],
            ]);
        }
    }
}
