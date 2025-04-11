<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = [
            [
                'name' => 'Matej Arh',
                'email' => 'matej.arh@gmail.com',
            ],
            [
                'name' => 'Čistilnica Suzi',
                'email' => 'cistilnica.suzi@gmail.com',
            ]
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

/*         User::factory()->create([
            'name' => 'Matej Arh',
            'email' => 'matej.arh@gmail.com',
        ]); */

    }
}
