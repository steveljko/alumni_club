<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostDefault extends Model
{
    public $fillable = [
        'body',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
