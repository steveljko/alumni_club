<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\Auth\ChangeInitialPassword;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Response;

final class ChangePasswordController
{
    public function __invoke(
        ChangePasswordRequest $request,
        ChangeInitialPassword $changeInitialPassword,
    ): Response {
        $ok = $changeInitialPassword->execute($request);

        if ($ok) {
            return response(Response::HTTP_NO_CONTENT)
                ->header('HX-Trigger', Json::encode(['toast' => 'Password changed successfully!']));
        }
    }
}
