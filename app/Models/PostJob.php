<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    protected $fillable = [
        'position',
        'description',
        'company_name',
        'company_website_url',
        'company_address',
        'company_city',
        'start_time',
        'end_time',
        'job_page_url',
        'is_remote',
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

    /**
     * Get job page url encoded
     */
    public function url(): string
    {
        return urlencode($this->job_page_url);
    }
}
