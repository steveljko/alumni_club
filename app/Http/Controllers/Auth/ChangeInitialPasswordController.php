<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HtmxResponse;
use App\Http\Actions\Auth\ChangeInitialPassword;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Response;

final class ChangeInitialPasswordController
{
    public function __invoke(
        ChangePasswordRequest $request,
        ChangeInitialPassword $changeInitialPassword,
    ): Response {
        $ok = $changeInitialPassword->execute($request);

        if ($ok) {
            return (new HtmxResponse)
                ->redirectTo('auth.setup.step.2')
                ->toast("Now let's add more details about you!")
                ->send();
        }
    }
}
