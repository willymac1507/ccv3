<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i < 11; $i++) {
            $organisation = Organisation::where('id', $i)->first();
            User::factory(10)
                ->create()
                ->each(function ($user) use ($organisation) {
                    $user->assignRole('Student');
                    $user->organisation()->associate($organisation)->save();
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'monday', 'dayNumber' => 1]);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'tuesday', 'dayNumber' => 2]);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'wednesday', 'dayNumber' => 3]);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'Thursday', 'dayNumber' => 4]);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'friday', 'dayNumber' => 5]);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'saturday', 'dayNumber' => 6]);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'sunday', 'dayNumber' => 7]);
                });
        }
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'monday', 'dayNumber' => 1]);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'tuesday', 'dayNumber' => 2]);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'wednesday', 'dayNumber' => 3]);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'Thursday', 'dayNumber' => 4]);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'friday', 'dayNumber' => 5]);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'saturday', 'dayNumber' => 6]);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'sunday', 'dayNumber' => 7]);
    }
}
