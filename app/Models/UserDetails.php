<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetails extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    public $fillable = [
        'date_of_birth',
        'gender',
        'email_visible',
        'phone_number',
        'phone_number_visible',
        'uni_start_year',
        'uni_finish_year',
        'bio',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function user(): HasOne
    {
        return $this->hasMany(User::class);
    }
}
