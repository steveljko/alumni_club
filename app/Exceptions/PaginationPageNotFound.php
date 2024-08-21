<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class PaginationPageNotFound extends Exception
{
    public function render(): JsonResponse
    {
        return $this->sendNotFound(key: 'additional.pagination.page_not_found');
    }
}
