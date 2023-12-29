<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Hotel;
use App\Models\Permission;
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
        foreach (RoleEnum::cases() as $role) {
            if (!Role::where('name', $role->value)->where('guard_name', 'web')->count()) {
                Role::factory()->create([
                    'name' => $role->value,
                    'guard_name' => 'web'
                ]);
            }
            if (!Role::where('name', $role->value)->where('guard_name', 'api')->count()) {
                Role::factory()->create([
                    'name' => $role->value,
                    'guard_name' => 'api'
                ]);
            }
        }

        foreach (PermissionEnum::cases() as $role) {
            if (!Permission::where('name', $role->value)->where('guard_name', 'web')->count()) {
                Permission::factory()->create([
                    'name' => $role->value,
                    'guard_name' => 'web'
                ]);
            }
            if (!Permission::where('name', $role->value)->where('guard_name', 'api')->count()) {
                Permission::factory()->create([
                    'name' => $role->value,
                    'guard_name' => 'api'
                ]);
            }
        }

        $email = 'admin@testdomain.com';
        if (!User::where('email', $email)->count()) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => $email,
                'is_active' => true,
            ]);
            $user->syncRoles([RoleEnum::ADMIN->value]);
        }

        User::factory(10)->create();

        Hotel::factory(10)->create();
    }
}
