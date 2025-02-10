<?php

namespace App\Http\Controllers\User\Settings\Password;

use App\Http\Actions\Auth\ForgotPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Response;

final class ForgotPasswordController extends Controller
{
    public function __invoke(
        ForgotPasswordRequest $request,
        ForgotPassword $forgotPassword,
    ): Response {
        $forgotPassword->execute($request);

        return $this->toast(__('auth.successful_forgot_password'));
    }
}
