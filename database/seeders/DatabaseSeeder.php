<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()
            ->create([
                'id' => 9999,
                'name' => 'Will McCloy',
                'email' => 'will@email.com',
                'password' => bcrypt('password'),
            ]);
        $user->assignRole(Role::findByName('Super Admin'));

        User::factory(20)
            ->hasAppointmentsAsClient(2)
            ->create()
            ->each(function ($user) {
                $user->assignRole(Role::findByName('Client'));
            });
    }
}
