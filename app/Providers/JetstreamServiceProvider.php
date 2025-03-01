<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use App\Enums\Permission;
use App\Enums\Role;
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
        Jetstream::defaultApiTokenPermissions([
            Permission::get->value,
        ]);

        Jetstream::role(Role::Admin->value, __('rolePermission.role.administrator'), [
            Permission::get->value,
            Permission::set->value,
        ])->description(__('rolePermission.role.administrator_description'));

        Jetstream::role(Role::User->value, __('rolePermission.role.user'), [
            Permission::get->value,
            Permission::set->value,
        ])->description(__('rolePermission.role.user_description'));

        Jetstream::role(Role::Guest->value, __('rolePermission.role.guest'), [
            Permission::get->value,
        ])->description(__('rolePermission.role.guest_description'));
    }
}
