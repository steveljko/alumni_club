<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostDefault extends Model
{
    use HasFactory;

    public $fillable = [
        'body',
    ];

    public function data(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
