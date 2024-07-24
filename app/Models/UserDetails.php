<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 
 *
 * @property int $id
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $phone_number
 * @property int $phone_number_visible
 * @property string|null $uni_start_year
 * @property string|null $uni_finish_year
 * @property string|null $bio
 * @property int $user_id
 * @property int $changed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereChanged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails wherePhoneNumberVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereUniFinishYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereUniStartYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetails whereUserId($value)
 * @mixin \Eloquent
 */
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
    'changed',
  ];

  /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
  public function user(): HasOne
  {
    return $this->hasMany(User::class);
  }
}
