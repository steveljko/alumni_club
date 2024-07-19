<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

// TODO: Find better way to define relationship alloedParams
class FilterModel
{
  /** @var array */
  private array $query = [];

  /** @var \Illuminate\Database\Eloquent\Builder */
  private Builder $builtQuery;

  /**
   * Array with alloed params for query.
   *
   * @var array<string, array>
   */
  private $allowedParams = [];

  /**
   * Textual representation of operators
   *
   * @var array<string, string>
   */
  private $operators = [
    'eq' => '=',    // equals
    'lt' => '<',    // less than
    'lte' => '<=',  // less than equals
    'gt' => '>',    // grater than
    'gte' => '>=',  // grater than equals
  ];

  /**
   * Run model query with specified query paramaters.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Illuminate\Database\Eloquent\Model $model
   * @param array<int,mixed> $allowedParams
   * @return \Illuminate\Database\Eloquent\Builder|static[]
   */
  public function __invoke(
    Request $request,
    Model $model,
    array $allowedParams = []
  ): FilterModel
  {
    // TODO: Handle unspecified query paramater used

    $this->allowedParams = $allowedParams;

    $query = $model->newQuery();

    $this->extractQueryConditions($request);

    foreach ($this->query as $key => $conditions) {
      if (is_string($key)) {
        $query->whereHas($key, function($q) use ($conditions) {
          foreach ($conditions as $condition) {
            $q->where(...$condition);
          }
        });
      } else {
        $query->where(...$conditions);
      }
    }

    $this->builtQuery = $query;

    return $this;
  }

  /**
   * @param mixed $with
   */
    public function get($with = []): Collection|array
  {
    if (count($with)) {
      return $this->builtQuery
        ->with($with)
        ->get();
    }

    return $this->builtQuery->get();
  }

  /**
   *  Extracts query conditions from the request parameters.
   *
   * @param \Illuminate\Http\Request $request
   * @return void
   */
  private function extractQueryConditions(Request $request): void
  {
    foreach ($this->allowedParams as $param => $operators)
    {
      $query = $request->query($param);

      if (!isset($query)) continue;

      foreach ($operators as $operator) {
        if (isset($query[$operator])) {

          if (!preg_match('/^\(.*\)$/', $param)) {
            $this->query[] = [$param, $this->operators[$operator], $query[$operator]];
          } else {
            if (preg_match('/^\((.*)\)$/', $param, $matches)) {
              $content = $matches[1];

              $parts = explode('_', $content, 2);

              $this->query[$parts[0]][] = [$parts[1], $this->operators[$operator], $query[$operator]];
            }
          }
        }
      }
    }
  }

}
