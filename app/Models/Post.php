<?php

namespace App\Models;

use App\Enums\Post\PostStatus;
use App\Enums\Post\PostType;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory;

    public $fillable = [
        'status',
        'type',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'type' => PostType::class,
    ];

    protected $with = ['default', 'event', 'job'];

    public function isDefault(): bool
    {
        return $this->type == PostType::DEFAULT;
    }

    public function isEvent(): bool
    {
        return $this->type == PostType::EVENT;
    }

    public function isJob(): bool
    {
        return $this->type == PostType::JOB;
    }

    public function isEventOrJob(): bool
    {
        return $this->type == PostType::EVENT || $this->type == PostType::JOB;
    }

    public function default(): HasOne
    {
        return $this->hasOne(PostDefault::class);
    }

    public function event(): HasOne
    {
        return $this->hasOne(PostEvent::class);
    }

    public function job(): HasOne
    {
        return $this->hasOne(PostJob::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
