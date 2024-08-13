<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class Controller
{
    private ?string $model = null;

    private ?string $type = null;

    public function __construct()
    {
        $ref = new \ReflectionClass($this);
        $class = $ref->getShortName();

        preg_match('/^[A-Z][a-z]*/', $class, $matches);

        if (count($matches) == 3) {
            $this->model = strtolower($matches[1]);
            $this->type = strtolower($matches[0]);
        } elseif (count($matches) == 4) {
            $this->model = strtolower($matches[2]);
            $this->type = strtolower($matches[0]);
        }
    }

    /**
     * Send success JSON message
     *
     * @var string
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

    /* Methods for sending localized messages in the controller */
    protected function sendOk(): JsonResponse
    {
        return $this->sendResponse(
            message: __("additional.{$this->getModel()}s.successful_{$this->getType()}")
        );
    }

    protected function sendUnauthorized(): JsonResponse
    {
        return $this->sendFailResponse(
            message: __("additional.{$this->getModel()}s.unauthorized"),
            status: Response::HTTP_UNAUTHORIZED,
        );
    }

    protected function sendForbidden(): JsonResponse
    {
        return $this->sendFailResponse(
            message: __("additional.{$this->getModel()}s.{$this->getType()}_failed"),
        );
    }

    /* Getters */
    protected function getModel(): ?string
    {
        return $this->model;
    }

    protected function getType(): ?string
    {
        return $this->type;
    }
}
