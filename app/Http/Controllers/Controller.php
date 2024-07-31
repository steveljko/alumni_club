<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class Controller
{
    /**
     * Send success JSON message
     *
     * @var string
     * @var
     * @var int
     */
    public function sendResponse(
        string $message = 'Success',
        $data = null,
        int $status = Response::HTTP_OK
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return new JsonResponse($response, $status);
    }

    /**
     * Send fail JSON message
     *
     * @var string
     * @var int
     */
    public function sendFailResponse(
        string $message = 'Failed',
        int $status = Response::HTTP_FORBIDDEN
    ): JsonResponse {
        return new JsonResponse([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
