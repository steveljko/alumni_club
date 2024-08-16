<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostEvent extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'description',
        'event_page_url',
        'start_time',
        'end_time',
        'address',
        'city',
    ];

    public function data(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function thumbImage()
    {
        return $this
            ->morphOne(Images::class, 'model')
            ->where('type', 'thumbnail_image');
    }
}
