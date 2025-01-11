<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
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

    protected function casts(): array
    {
        return [
            'opening_start' => 'datetime',
            'opening_end' => 'datetime',
        ];
    }
}
