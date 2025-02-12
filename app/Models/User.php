<?php

namespace App\Models;

use App\Enums\Auth\AccountSetupProgress;
use App\Observers\UserObserver;
use App\Traits\Auth\CanChangePassword;
use App\Traits\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use CanChangePassword,
        CanResetPassword,
        HasFactory,
        HasRoles,
        Notifiable,
        SoftDeletes;

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

    /**
     * User's previous work history
     */
    public function workHistory(): HasMany
    {
        return $this->hasMany(WorkHistory::class)
            ->orderBy('start_date', 'desc')
            ->orderBy('created_at', 'desc');
    }

    public function currentWork(): ?WorkHistory
    {
        return Cache::rememberForever('current_work:'.$this->id, function () {
            return $this->workHistory()->where('end_date', null)->first() ?: null;
        });
    }

    /**
     * Check if user has unpublished work histories
     */
    public function hasUnpublishedWorkHistories(): bool
    {
        return $this->workHistory()->where('is_draft', true)->count() >= 1;
    }

    /**
     * User posts
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /** Post likes */
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'posts_likes', 'user_id', 'post_id');
    }

    public function isLiked(Post $post)
    {
        return $this->likedPosts()->where('post_id', $post->id)->exists();
    }

    public function likePost(Post $post)
    {
        if ($this->isLiked($post)) {
            return false;
        }

        $this->likedPosts()->attach($post->id);

        return true;
    }

    public function dislikePost(Post $post)
    {
        if (! $this->isLiked($post)) {
            return false;
        }

        $this->likedPosts()->detach($post->id);

        return true;
    }
}
