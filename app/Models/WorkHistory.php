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
        'is_draft',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function calcYearsInCompany(): string
    {
        $diff = Carbon::parse($this->start_date)->diff($this->end_date);

        if ($diff->y > 0) {
            return $diff->y.' year'.($diff->y > 1 ? 's' : '');
        } elseif ($diff->m > 0) {
            return $diff->m.' month'.($diff->m > 1 ? 's' : '');
        } else {
            return $diff->d.' day'.($diff->d > 1 ? 's' : '');
        }
    }
}
