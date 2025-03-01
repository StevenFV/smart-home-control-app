<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * The first user created by UserFactory is a developer user with dev password from the configuration.
     * Later users are fake users with default password from the configuration.
     */
    public function definition(): array
    {
        $isUserDevExist = self::isUserDevExist();

        return [
            'name' => $isUserDevExist ? fake()->name() : config('auth.dev.name'),
            'email' => $isUserDevExist ? fake()->unique()->safeEmail() : config('auth.dev.email'),
            'email_verified_at' => now(),
            'password' => $isUserDevExist ?
                Hash::make(config('auth.defaults.passwords')) :
                Hash::make(config('auth.dev.passwords')),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn(array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams',
        )->afterCreating(function (User $user) {
            $team = $user->ownedTeams()->first();
            if ($team) {
                $user->current_team_id = $team->id;
                $user->save();
            }
        });
    }

    /**
     * Indicate that the user should have an admin role.
     */
    public function withAdminRole(): static
    {
        return $this->afterCreating(function (User $user) {
            $team = $user->ownedTeams()->first();

            if ($team) {
                $team->users()->attach($user->id, ['role' => Role::Admin->value]);
            }
        });
    }

    /**
     * Checks if a developer user exists based on the email provided in the configuration.
     *
     * @return bool True if the developer user exists, otherwise false.
     */
    public static function isUserDevExist(): bool
    {
        return User::where('email', config('auth.dev.email'))->exists();
    }

    /**
     * Retrieves the user password based on the existence of a developer user.
     *
     * This method selects the appropriate password according to the UserFactory::definition() logic.
     *
     * @return string The selected password from the configuration.
     */
    public static function getUserPassword(): string
    {
        return UserFactory::isUserDevExist() ? config('auth.dev.passwords') : config('auth.defaults.passwords');
    }
}
