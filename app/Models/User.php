<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Observers\UserObserver;
use App\Traits\HasOwnership;
use App\Traits\Filterable;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
  use
    HasOwnership,
    HasFactory,
    Filterable,
    Notifiable,
    HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  /** @var \Illuminate\Database\Eloquent\Relations\HasOne */
  public function details(): HasOne
  {
    return $this->hasOne(UserDetails::class);
  }

  /** @var \Illuminate\Database\Eloquent\Relations\HasMany */
  public function jobs(): HasMany
  {
    return $this->hasMany(UserJobs::class);
  }
}
