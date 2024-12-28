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
        'finished_details',
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

    public function areDetailsChanged(): bool
    {
        return $this->finished_details;
    }

    public function setDetails(array $details): bool
    {
        return $this->update([
            'uni_start_year' => $details['uni_start_year'],
            'uni_finish_year' => $details['uni_finish_year'],
            'bio' => $details['bio'],
            'finished_details' => true,
        ]);
    }

    /**
     * Check if user has finished any of their setup steps.
     */
    public function isSetupComplete(): bool
    {
        return $this->isInitialPasswordChanged() && $this->areDetailsChanged();
    }

    public function workHistory(): HasMany
    {
        return $this->hasMany(WorkHistory::class);
    }
}
