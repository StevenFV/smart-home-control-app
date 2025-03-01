<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Determine if the current user has the specified role.
     */
    public function hasRole(string $role): bool
    {
        return $this->getRole() === $role;
    }

    /**
     * Determine if the current user has any of the specified roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return collect($roles)->contains(fn($role) => $this->hasRole($role));
    }

    /**
     * Retrieve the role of the current user within the current team.
     */
    protected function getRole(): ?string
    {
        return $this->currentTeam->users()->where('users.id', $this->id)->first()->membership->role ?? null;
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @override vendor/laravel/jetstream/src/HasProfilePhoto.php
     */
    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(
            collect(explode(' ', $this->name))->map(function ($segment) {
                return mb_substr($segment, 0, 1);
            })->join(' '),
        );

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=4ADE80&background=EBFFF0';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
