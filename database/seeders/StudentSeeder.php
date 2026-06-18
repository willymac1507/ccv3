<?php

namespace Database\Seeders;

use App\Models\Organisation;
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
                });

        }
    }
}
