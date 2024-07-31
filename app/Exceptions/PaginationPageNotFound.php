<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

class PaginationPageNotFound extends Exception
{
  public function render(): JsonResponse
  {
    return new JsonResponse([
      'success' => false,
      'message' => __('additional.pagination.page_not_found'),
    ], Response::HTTP_NOT_FOUND);
  }
}
