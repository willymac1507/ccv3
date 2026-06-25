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
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'monday']);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'tuesday']);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'wednesday']);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'Thursday']);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'friday']);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'saturday']);
                    Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => $user->id, 'day' => 'sunday']);
                });
        }
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'monday']);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'tuesday']);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'wednesday']);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'Thursday']);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'friday']);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'saturday']);
        Shift::create(['uuid' => Str::uuid()->toString(), 'user_id' => 9999, 'day' => 'sunday']);
    }
}
