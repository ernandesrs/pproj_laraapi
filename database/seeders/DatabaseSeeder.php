<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Api\Roles\RolesEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run user seeder
        (new UserSeeder())->run();

        // Create roles and permissions
        Role::defaultRoles()->map(fn($dr) => Role::create(['guard_name' => 'web', 'name' => $dr->value]));

        User::find(1)->assignRole(RolesEnum::SUPER_ADMIN);
        User::find(2)->assignRole(RolesEnum::USER_ADMIN);
    }
}
