<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions([]);

        $permissions = [];
        foreach(PermissionEnum::cases() as $permission) {
            $permissions[] = $permission->value;
        }

        Jetstream::permissions($permissions);

        Jetstream::role(RoleEnum::ADMIN->value, RoleEnum::ADMIN->label(), $permissions)->description(trans('roles.admin_description'));

        Jetstream::role(RoleEnum::MANAGER->value, RoleEnum::MANAGER->label(), [
            PermissionEnum::HOTEL_LIST->value,
            PermissionEnum::HOTEL_CREATE->value,
            PermissionEnum::HOTEL_UPDATE->value,
            PermissionEnum::HOTEL_DELETE->value,
        ])->description(trans('roles.manager_description'));

        Jetstream::role(RoleEnum::USER->value, RoleEnum::USER->label(), [])->description(trans('roles.user_description'));

    }
}
