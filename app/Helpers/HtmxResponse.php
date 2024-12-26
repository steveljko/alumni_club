<?php

namespace App\Helpers;

use Illuminate\Http\Response;

final class HtmxResponse
{
    private array $headers = [];

    /**
     * Send redirect response
     */
    public function redirectTo(string $routeName): self
    {
        $this->headers['HX-Redirect'] = route($routeName);

        return $this;
    }

    /**
     * Send toast notification
     */
    public function toast(string $message): self
    {
        if (isset($this->headers['HX-Redirect'])) {
            $this->headers['HX-Trigger'] = json_encode(['toast-after-redirect' => $message]);

            return $this;
        }

        $this->headers['HX-Trigger'] = json_encode(['toast' => $message]);

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
