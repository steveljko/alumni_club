<?php

namespace App\Models;

use App\Enums\Auth\AccountSetupProgress;
use App\Observers\UserObserver;
use App\Traits\Auth\CanChangePassword;
use App\Traits\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use CanChangePassword;
    use CanResetPassword;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

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
        'avatar',
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
        return $this->setup_progress == AccountSetupProgress::COMPLETED->value;
    }

    /*
     * ##########################
     * #      Work History      #
     * ##########################
     */
    public function workHistory(): HasMany
    {
        return $this->hasMany(WorkHistory::class)
            ->orderBy('start_date', 'desc')
            ->orderBy('created_at', 'desc');
    }

    // Get users current work
    public function currentWork(): HasOne
    {
        return $this
            ->hasOne(WorkHistory::class)
            ->where('end_date', null);
    }

    // Check if user has unpublished works
    public function hasUnpublishedWorkHistories(): bool
    {
        return $this->workHistory()->where('is_draft', true)->count() >= 1;
    }

    /*
     * ##########################
     * #       User Posts       #
     * ##########################
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /*
     * ##########################
     * #     Comments Posts     #
     * ##########################
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /*
     * ##########################
     * #  Posts liked by user   #
     * ##########################
     */
    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, PostLike::class);
    }

    // Check if provided post is liked by user
    public function isLiked(Post $post): bool
    {
        return $this
            ->likedPosts()
            ->where('post_id', $post->id)
            ->exists();
    }

    /*
     * ##########################
     * #       Activities       #
     * ##########################
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
