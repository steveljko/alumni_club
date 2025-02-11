<?php

namespace App\Http\Controllers\User\Settings\Password;

use App\Http\Actions\Auth\ChangePassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordWithVerificationRequest;
use Illuminate\Http\Response;

final class ChangePasswordController extends Controller
{
    public function __invoke(
        ChangePasswordWithVerificationRequest $request,
        ChangePassword $changePassword
    ): Response {
        $ok = $changePassword->execute(request: $request, user: auth()->user());

        if (! $ok) {
            return $this->toast(__('auth.wrong_current_password'));
        }

        return $this->redirectWithToast(
            route: 'users.settings',
            message: __('auth.successful_password_change')
        );
    }
}
