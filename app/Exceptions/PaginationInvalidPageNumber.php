<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PaginationInvalidPageNumber extends Exception
{
    public function render(): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => __('additional.pagination.invalid_page_number'),
        ], Response::HTTP_NOT_FOUND);
    }
}
