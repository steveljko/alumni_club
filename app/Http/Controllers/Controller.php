<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller
{
  public function sendResponse(
    string $message = 'Success',
    $data = [],
    $status = Response::HTTP_OK
  ): JsonResponse
  {
    return new JsonResponse([
      'success' => true,
      'message' => $message,
      'data' => $data,
    ], $status);
  }

  public function sendFailResponse(
    string $message = 'Failed',
    $status = Response::HTTP_FORBIDDEN
  ): JsonResponse
  {
    return new JsonResponse([
      'success' => false,
      'message' => $message,
    ], $status);
  }
}
