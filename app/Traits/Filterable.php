<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Enums\FilterOperators;
use Illuminate\Support\Arr;

// TODO: If allowedParams is not specified, than enable for all fields all operators
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
    FilterOperators::EQUALS => '=',
    FilterOperators::LESS_THAN => '<',
    FilterOperators::LESS_THAN_EQUALS => '<=',
    FilterOperators::GRATER_THAN => '>',
    FilterOperators::GRATER_THAN_EQUALS => '>=',
  ];

  /**
   * Function that filters by url query parameters.
   *
   * @param array<int,mixed> $query
   * @param array<int,mixed> $allowedParams
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public static function filter(
    array $query = [],
    array $allowedParams = []
  ): Builder
  {
    // TODO: Handle unspecified query paramater used

    $instance = new self();
    $instance->allowedParams = $instance->remapArray($allowedParams);
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
   * Remap nasted values.
   *
   * @param array<int,mixed> $array
   * @return array<string, mixed>
   */
  private function remapArray(array $array): array
  {
    $result = [];

    foreach ($array as $key => $value) {
      if (is_array($value)) {
        if (!Arr::isAssoc($value)) {
          $result[$key] = $value;
        } else {
          // Handle nested associative arrays
          foreach ($value as $nestedKey => $nestedValue) {
            $newKey = "{$key}_{$nestedKey}";
            $result[$newKey] = $nestedValue;
          }
        }
      } else {
        $result[$key] = $value;
      }
    }

    return $result;
  }

  /**
   * Extracts query conditions from the request parameters.
   *
   * @param array<int,mixed> $query
   * @return void
   */
  private function extractQueryConditions(array $query): void
  {
    foreach ($this->allowedParams as $param => $operators) {
      // Check if the URL parameter is present in the query array.
      // If the parameter is not found, skip the current iteration of the loop.
      if (!isset($query[$param])) continue;

      // Retrieve the value from the URL query parameter.
      $q = $query[$param];

      foreach ($operators as $operator) {
        if (isset($q[$operator])) {
          if (preg_match('/^(.*?)_(.*?)$/', $param, $matches)) {
            $this->query[$matches[1]][] = [$matches[2], $this->operators[$operator], $q[$operator]];
          } else {
            $this->query[] = [$param, $this->operators[$operator], $q[$operator]];
          }
        }
      }
    }
  }
}
