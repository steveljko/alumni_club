<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

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
    'desc'
  ];

  /** @return \Illuminate\Database\Eloquent\Relation\HasOne */
  public function user(): HasOne
  {
    return $this->hasOne(User::class);
  }
}
