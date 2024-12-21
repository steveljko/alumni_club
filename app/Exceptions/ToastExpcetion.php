<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Response;

class ToastExpcetion extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(): Response
    {
        return response(Response::HTTP_NOT_FOUND)
            ->header('HX-Trigger',
                Json::encode(['toast' => $this->message]));
    }
}
