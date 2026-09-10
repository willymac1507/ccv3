<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::factory()
            ->count(21)
            ->sequence(
                ['sender' => 10012],
                ['sender' => 10013],
                ['sender' => 10014],
            )
            ->create([
                'receiver' => 9999,
            ]);
        Message::factory()
            ->count(21)
            ->sequence(
                ['receiver' => 10012],
                ['receiver' => 10013],
                ['receiver' => 10014],
            )
            ->create([
                'sender' => 9999,
            ]);
    }
}
