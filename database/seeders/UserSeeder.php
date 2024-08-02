<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'username' => 'superuser',
            'gender' => 'm',
            'email' => 'super@mail.com',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'adminuser',
            'gender' => 'm',
            'email' => 'admin@mail.com',
        ]);

        \App\Models\User::factory(25)->create();
        \App\Models\User::factory(15)->unverified()->create();
    }
}
