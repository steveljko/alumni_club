<?php

namespace App\Traits;


// TODO: If allowedParams is not specified, than enable for all fields all operators
// TODO: Find better way to define relationship allowed params
trait Filterable
{
  /** @var array */
  private array $query = [];

  /**
   * Array with alloed params for query.
   *
   * @var array<string, array>
   */
  private $allowedParams = [];

  /**
   * Textual representation of operators.
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
   * @param array<int,mixed> $query
   * @param array<int,mixed> $allowedParams
   */
  public static function filter(
    array $query = [],
    array $allowedParams = []
  )
  {
    // TODO: Handle unspecified query paramater used

    $instance = new self();
    $instance->allowedParams = $allowedParams;
    $instance->extractQueryConditions($query);

    $query = $instance->newQuery();

    foreach ($instance->query as $key => $conditions) {
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

    return $query;
  }

  /**
   *  Extracts query conditions from the request parameters.
   *
   * @param array<int,mixed> $query
   * @return void
   */
  private function extractQueryConditions(array $query): void
  {
    foreach ($this->allowedParams as $param => $operators)
    {
      if (!isset($query[$param])) continue;

      $q = $query[$param];

      foreach ($operators as $operator) {
        if (isset($q[$operator])) {

          if (!preg_match('/^\(.*\)$/', $param)) {
            $this->query[] = [$param, $this->operators[$operator], $q[$operator]];
          } else {
            if (preg_match('/^\((.*)\)$/', $param, $matches)) {
              $content = $matches[1];

              $parts = explode('_', $content, 2);

              $this->query[$parts[0]][] = [$parts[1], $this->operators[$operator], $q[$operator]];
            }
          }
        }
      }
    }
  }
}
