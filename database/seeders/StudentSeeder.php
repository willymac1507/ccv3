<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Seeder;

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
                    Shift::create(['user_id' => $user->id, 'day' => 'monday']);
                    Shift::create(['user_id' => $user->id, 'day' => 'tuesday']);
                    Shift::create(['user_id' => $user->id, 'day' => 'wednesday']);
                    Shift::create(['user_id' => $user->id, 'day' => 'Thursday']);
                    Shift::create(['user_id' => $user->id, 'day' => 'friday']);
                    Shift::create(['user_id' => $user->id, 'day' => 'saturday']);
                    Shift::create(['user_id' => $user->id, 'day' => 'sunday']);
                });
        }
        Shift::create(['user_id' => 9999, 'day' => 'monday']);
        Shift::create(['user_id' => 9999, 'day' => 'tuesday']);
        Shift::create(['user_id' => 9999, 'day' => 'wednesday']);
        Shift::create(['user_id' => 9999, 'day' => 'Thursday']);
        Shift::create(['user_id' => 9999, 'day' => 'friday']);
        Shift::create(['user_id' => 9999, 'day' => 'saturday']);
        Shift::create(['user_id' => 9999, 'day' => 'sunday']);
    }
}
