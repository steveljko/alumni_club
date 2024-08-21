<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait Responses
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

    /*
     * Methods for sending localized messages in the controller
     *
     * All metods use...
     */

    /**
     * Send message with OK status code
     *
     * @param  mixed  $key
     * @param data
     */
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

    /**
     * Send message with CREATED status code
     *
     * @param  mixed  $key
     * @param data
     */
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

    /**
     * Send message with UNAUTHORIZED status code
     *
     * @param  mixed  $key
     */
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

    /**
     * Send message with FORBIDDEN status code
     *
     * @param  mixed  $key
     */
    protected function sendForbidden(?string $key = null): JsonResponse
    {
        $message = ! $key ?
            __("additional.{$this->getModel()}s.{$this->getType()}_failed") :
            __($key);

        return $this->sendFailResponse(
            message: $message
        );
    }

    /**
     * Send message with NOT FOUND status code
     *
     * @param  mixed  $key
     */
    protected function sendNotFound(?string $key = null): JsonResponse
    {
        $message = ! $key ?
            __("additional.{$this->getModel()}s.{$this->getType()}_failed") :
            __($key);

        return $this->sendFailResponse(
            message: $message,
            status: Response::HTTP_NOT_FOUND,
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
