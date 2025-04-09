<?php

namespace Database\Factories;

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
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * The current name being used by the factory.
     */
    protected static ?string $name;

    /**
     * The current email being used by the factory.
     */
    protected static ?string $email;

    /**
     * The current role being used by the factory.
     */
    protected static ?int $roleId;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => static::$name ??= fake()->name(),
            'email' => static::$email ??= fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'role_id' => static::$roleId ??= fake()->unique()->numberBetween(1, 3),
            // 'profile_photo_path' => null,
            // 'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
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
                ->state(fn (array $attributes, User $user) => [
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
}
