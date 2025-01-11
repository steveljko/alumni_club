<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostEvent extends Model
{
    public $fillable = [
        'title',
        'description',
        'event_page_url',
        'start_time',
        'end_time',
        'address',
        'city',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
}
