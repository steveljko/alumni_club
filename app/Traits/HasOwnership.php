<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasOwnership
{
    /**
     * Determine if user owns given model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     * @var string
     */
    public function owns(Model $model, ?string $field = null): bool
    {
        $field = $field ?? 'user_id';

        return $this->id === $model->{$field};
    }
}
