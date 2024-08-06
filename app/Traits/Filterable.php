<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PaginateResource;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\PaginationPageNotFound;
use App\Exceptions\PaginationInvalidPageNumber;

trait Filterable
{
    public array $query = [];

    /**
     * Array with allowed params for query.
     *
     * @var array<string, mixed>
     */
    private $allowedParams = [];

    /**
     * Filters model with query parameters
     *
     * This function filters the provided query parameters according to the allowed parameters
     * and constructs a query using Eloquent's query builder. It supports filtering by both direct
     * conditions and relationships using the `whereHas` method.
     *
     * @param  array<int, mixed>  $allowedParams  List of allowed filter parameters.
     */
    public static function filter(array $allowedParams = []): Builder
    {
        $instance = new self();
        $instance->allowedParams = $instance->remapArray($allowedParams);
        $instance->extractQueryConditions(request()->query());

        $className = class_basename(static::class);
        Log::info("Filtering is executed on model $className with ", $instance->query);

        $query = $instance->newQuery();

        foreach ($instance->query as $key => $conditions) {
            if (is_string($key)) {
                $query->whereHas($key, function ($q) use ($conditions) {
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
     * Processes and filters query parameters for fetching paginated data.
     *
     * This function takes an array of query parameters, filters them according to the allowed parameters,
     * and prepares the data for retrieval with the specified relationships eagerly loaded. The result is
     * mapped into a specified resource class, and pagination is applied based on the provided number of records per page.
     *
     * @param  array<int, mixed>  $allowedParams  List of allowed filter parameters.
     * @param  array<int, mixed>  $with  List of relationships to be eager loaded.
     * @param  string  $resource  Resource class to map returned data.
     * @param  int  $records  Number of elements per page.
     */
    public static function filterWithPagination(
        array $allowedParams,
        array $with,
        string $resource,
        int $records = 10,
    ) {
        $instance = new self();
        $query = $instance->filter($allowedParams);

        if (($page = request()->query('page', 1)) < 1) {
            throw new PaginationInvalidPageNumber();
        }

        if (count($with)) {
            $query =
              $query
                  ->with($with)
                  ->paginate($records);
        } else {
            $query = $query->paginate($records);
        }

        $query = $query->withQueryString(); // append all query parametrs to pagination urls

        if ($page > $query->lastPage()) {
            throw new PaginationPageNotFound();
        }

        $result = PaginateResource::make($query, $resource);

        return new class ($result, $result->count()) {
            public function __construct(
                private object $data,
                private int $count
            ) {
                $this->data = $data;
                $this->count = $count;
            }

            public function getData(): object
            {
                return $this->data;
            }

            public function getCount(): int
            {
                return $this->count;
            }

            public function empty(): bool
            {
                return $this->getCount() <= 0;
            }
        };
    }

    /**
     * Remap nasted values.
     *
     * @param  array<int,mixed>  $array
     * @return array<string, mixed>
     */
    private function remapArray(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (! Arr::isAssoc($value)) {
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
     * @param  array<int,mixed>  $query
     */
    private function extractQueryConditions(array $query): void
    {
        foreach ($this->allowedParams as $param => $operators) {
            // Check if the URL parameter is present in the query array.
            // If the parameter is not found, skip the current iteration of the loop.
            if (! isset($query[$param])) {
                continue;
            }

            // Retrieve the value from the URL query parameter.
            $q = $query[$param];

            foreach ($operators as $operator) {
                if (isset($q[$operator->getUrlParam()])) {
                    if (preg_match('/^(.*?)_(.*?)$/', $param, $matches)) {
                        $this->query[$matches[1]][] = [
                            $matches[2],
                            $operator->getQueryParam(),
                            $q[$operator->getUrlParam()],
                        ];
                    } else {
                        $this->query[] = [
                            $param,
                            $operator->getQueryParam(),
                            $q[$operator->getUrlParam()],
                        ];
                    }
                }
            }
        }
    }
}
