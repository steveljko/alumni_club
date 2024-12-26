<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HtmxResponse;
use App\Http\Actions\Auth\ChangeInitialPassword;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Response;

final class ChangePasswordController
{
    public function __invoke(
        ChangePasswordRequest $request,
        ChangeInitialPassword $changeInitialPassword,
    ): Response {
        $ok = $changeInitialPassword->execute($request);

        if ($ok) {
            return (new HtmxResponse)
                ->toast('Password changed successfully!')
                ->send();
        }
    }
}
