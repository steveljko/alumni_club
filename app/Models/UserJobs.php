<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $company_name
 * @property string $position
 * @property string $start_date
 * @property string|null $end_date
 * @property string|null $desc
 * @property int $user_id
 * @property int $current
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserJobs whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserJobs extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    public $fillable = [
        'company_name',
        'position',
        'start_date',
        'end_date',
        'current',
        'desc',
    ];

    /** @return \Illuminate\Database\Eloquent\Relation\HasOne */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
