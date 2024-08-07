<?php

namespace App\Models;

use App\Enums\PostType;
use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    public $fillable = [
        'status',
        'type',
        'likes_count',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'type' => PostType::class,
    ];

    public function default(): HasOne
    {
        return $this->hasOne(PostDefault::class);
    }

    public function event(): HasOne
    {
        return $this->hasOne(PostEvent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
