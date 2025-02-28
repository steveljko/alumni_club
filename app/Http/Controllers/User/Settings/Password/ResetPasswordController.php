<?php

namespace App\Http\Controllers\User\Settings\Password;

use App\Http\Actions\Auth\ResetPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Response;

final class ResetPasswordController extends Controller
{
    public function __invoke(
        ChangePasswordRequest $request,
        ResetPassword $resetPassword
    ): Response {
        $ok = $resetPassword->execute($request);

        if (! $ok) {
            return $this->toast('something went wrong!');
        }

        return $this->redirectWithToast(
            route: 'home',
            message: __('auth.successful_password_reset'),
        );
    }
}
