<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Images extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 'type', 'uploaded_by',
    ];
}
