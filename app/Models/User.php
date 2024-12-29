<?php

namespace App\Models;

use App\Traits\Auth\CanChangePassword;
use App\Traits\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CanChangePassword,
        CanResetPassword,
        HasFactory,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uni_start_year',
        'uni_finish_year',
        'bio',
        'setup_progress',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'password_reset_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
            'initial_password_changed_at' => 'datetime',
            'password_reset_token_generated_at' => 'datetime',
        ];
    }

    /**
     * Set account details for setup wizard
     */
    public function setDetails(array $details): bool
    {
        return $this->update([
            'uni_start_year' => $details['uni_start_year'],
            'uni_finish_year' => $details['uni_finish_year'],
            'bio' => $details['bio'],
            'setup_progress' => 'step.3',
        ]);
    }

    /**
     * Checks if setup is completed.
     */
    public function isSetupComplete(): bool
    {
        return $this->setup_progress == 'completed';
    }

    /**
     * User's previous work history
     */
    public function workHistory(): HasMany
    {
        return $this->hasMany(WorkHistory::class);
    }
}
