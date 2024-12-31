<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'position',
        'start_date',
        'end_date',
        'description',
    ];

    public function getStartDateAttribute($value): string
    {
        return Carbon::parse($value)->format('d M Y');
    }

    public function getEndDateAttribute($value): string
    {
        return Carbon::parse($value)->format('d M Y');
    }
}
