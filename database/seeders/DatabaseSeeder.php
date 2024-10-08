<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Roles\RolesEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run user seeder
        (new UserSeeder())->run();

        // Create roles
        Role::defaultRoles()->map(fn($defaultRole) => Role::create(['guard_name' => 'web', 'name' => $defaultRole->value]));

        // Assing role to user
        User::find(1)->assignRole(RolesEnum::SUPER_ADMIN);
        User::find(2)->assignRole(RolesEnum::USER_ADMIN);

        // Create permissions
        Permission::avaiablePermissions()->map(function ($allowedPermission, $allowedPermissionKey) {
            Collection::make($allowedPermission)->map(function ($permission) {
                Permission::create(['guard_name' => 'web', 'name' => $permission->value]);
            });
        });

        // Give all permissions to super user role
        Role::findByName(RolesEnum::SUPER_ADMIN->value)->givePermissionTo(
            Permission::all()
        );
    }
}
