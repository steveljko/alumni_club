<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

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
