<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Hotel;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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

        $email = 'admin@example.com';
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => RoleEnum::ADMIN->value,
                'email' => $email,
            ]);
        }

        $teamName = RoleEnum::ADMIN->value;
        $team = Team::where('name', $teamName)->first();

        if (!$team) {
            $team = Team::create([
                'user_id' => $user->id,
                'name' => $teamName,
                'personal_team' => true
            ]);
        }

        foreach (RoleEnum::cases() as $role) {
            if (!Role::where('name', $role->value)->where('guard_name', 'web')->count()) {
                Role::factory()->create([
                    'name' => $role->value,
                    'guard_name' => 'web',
                    // 'team_id' => $team->id
                ]);
            }
            if (!Role::where('name', $role->value)->where('guard_name', 'api')->count()) {
                Role::factory()->create([
                    'name' => $role->value,
                    'guard_name' => 'api',
                    // 'team_id' => $team->id
                ]);
            }
        }

        User::factory(10)->create();

        Hotel::factory(10)->create();

        $role = Role::where('name', RoleEnum::ADMIN->value)
            ->where('guard_name', 'web')
            ->firstOrFail();

        $user->syncRoles([$role]);

        DB::table('team_user')->where('user_id', $user->id)->delete();
        DB::table('team_user')->insert([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role' => RoleEnum::ADMIN->value,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
