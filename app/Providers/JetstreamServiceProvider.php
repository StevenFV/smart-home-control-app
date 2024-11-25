<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use App\Enums\PermissionName;
use App\Enums\PermissionRole;
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
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions([PermissionName::Read->value]);

        Jetstream::role(PermissionRole::Admin->value, __('rolePermission.role.administrator'), [
            PermissionName::Create->value,
            PermissionName::Read->value,
            PermissionName::Update->value,
            PermissionName::Delete->value,
            PermissionName::ManageDevices->value,
            PermissionName::ManageUsers->value,
            PermissionName::ViewLogs->value,
        ])->description(__('rolePermission.role.administrator_description'));

        Jetstream::role(PermissionRole::User->value, __('rolePermission.role.user'), [
            PermissionName::Read->value,
            PermissionName::Create->value,
            PermissionName::Update->value,
            PermissionName::ControlDevices->value,
        ])->description(__('rolePermission.role.user_description'));
    }
}
