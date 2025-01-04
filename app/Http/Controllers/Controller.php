<?php

namespace App\Http\Controllers;

use App\Helpers\HtmxResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    /**
     * Redirect using HTMX
     */
    public function redirect(string $route): Response
    {
        return (new HtmxResponse)
            ->redirectTo(routeName: $route)
            ->send();
    }

    /**
     * Trigger event using HTMX
     */
    public function trigger(string $event): Response
    {
        return (new HtmxResponse)
            ->trigger(event: $event)
            ->send();
    }

    /**
     * Send toast message using HTMX
     */
    public function toast(string $message): Response
    {
        return (new HtmxResponse)
            ->toast(message: $message)
            ->send();
    }

    /**
     * Send toast message along with redirect request using HTMX
     */
    public function redirectWithToast(string $route, string $message): Response
    {
        return (new HtmxResponse)
            ->redirectTo(routeName: $route)
            ->toast(message: $message)
            ->send();
    }
}
