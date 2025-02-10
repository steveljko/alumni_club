<?php

namespace App\Http\Controllers\User\Settings\Password;

use App\Http\Actions\Auth\ChangeInitialPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Response;

final class ChangeInitialPasswordController extends Controller
{
    public function __invoke(
        ChangePasswordRequest $request,
        ChangeInitialPassword $changeInitialPassword,
    ): Response {
        $ok = $changeInitialPassword->execute($request);

        if (! $ok) {
            return $this->toast(__('setup.step1.try_again'));
        }

        return $this->redirectWithToast(
            route: 'auth.setup.step.2', message: __('setup.step1.success')
        );
    }
}
