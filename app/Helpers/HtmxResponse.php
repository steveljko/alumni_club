<?php

namespace App\Helpers;

use Illuminate\Http\Response;

final class HtmxResponse
{
    const REDIRECT = 'HX-Redirect';

    const TRIGGER = 'HX-Trigger';

    private array $headers = [];

    /**
     * Send redirect response
     */
    public function redirectTo(string $routeName): self
    {
        $this->headers[self::REDIRECT] = route($routeName);

        return $this;
    }

    /**
     * Send trigger response
     */
    public function trigger(string $event): self
    {
        if (isset($this->headers[self::TRIGGER])) {
            $this->headers[self::TRIGGER][] = $event;
        }

        $this->headers[self::TRIGGER] = $event;

        return $this;
    }

    /**
     * Send toast notification
     */
    public function toast(string $message): self
    {
        // If the trigger header is set, send the toast message along with the previously added event.
        if (isset($this->headers[self::TRIGGER])) {
            $this->headers[self::TRIGGER] = json_encode([
                $this->headers[self::TRIGGER] => null,
                'toast' => $message,
            ]);

            return $this;
        }

        // If the redirect header is set, prepare to show the toast message on the redirected page.
        if (isset($this->headers[self::REDIRECT])) {
            $this->headers[self::TRIGGER] = json_encode(['toast-after-redirect' => $message]);

            return $this;
        }

        $this->headers[self::TRIGGER] = json_encode(['toast' => $message]);

        return $this;
    }

    public function send(): Response
    {
        $response = response(Response::HTTP_NO_CONTENT);

        foreach ($this->headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
