<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'description',
        'company_name',
        'company_city',
        'opening_start',
        'opening_end',
        'job_page_url',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
