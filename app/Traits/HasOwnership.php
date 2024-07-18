<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasOwnership
{
  /**
   * Determine if user owns given model.
   *
   * @var \Illuminate\Database\Eloquent\Model $model
   * @var string $field
   * @return bool
   */
  public function owns(Model $model, string $field = null): bool
  {
    $field = $field ?? 'user_id';

    return $this->id === $model->{$field};
  }
}
