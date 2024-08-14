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

        $matches = preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);

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
    protected function sendOk(
        ?string $key = null,
        $data = null,
    ): JsonResponse {
        $message = ! $key ?
            __("additional.{$this->getModel()}s.successful_{$this->getType()}") :
            __($key);

        return $this->sendResponse(
            message: $message,
            data: $data,
        );
    }

    protected function sendCreated(
        ?string $key = null,
        $data = null,
    ): JsonResponse {
        $message = ! $key ?
            __("additional.{$this->getModel()}s.successful_create") :
            __($key);

        return $this->sendResponse(
            message: $message,
            data: $data,
            status: Response::HTTP_CREATED
        );
    }

    protected function sendUnauthorized(?string $key = null): JsonResponse
    {
        $message = ! $key ?
            __("additional.{$this->getModel()}s.unauthorized") :
            __($key);

        return $this->sendFailResponse(
            message: $message,
            status: Response::HTTP_UNAUTHORIZED,
        );
    }

    protected function sendForbidden(?string $key = null): JsonResponse
    {
        $message = ! $key ?
            __("additional.{$this->getModel()}s.{$this->getType()}_failed") :
            __($key);

        return $this->sendFailResponse(
            message: $message
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
