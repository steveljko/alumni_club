<?php

namespace App\Exceptions;

use Exception;
use App\Traits\Responses;
use Illuminate\Http\JsonResponse;

class PaginationInvalidPageNumber extends Exception
{
    use Responses;

    public function render(): JsonResponse
    {
        return $this->sendNotFound(key: 'additional.pagination.invalid_page_number');
    }
}
