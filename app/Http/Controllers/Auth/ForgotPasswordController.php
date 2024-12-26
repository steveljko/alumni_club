<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HtmxResponse;
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

        return (new HtmxResponse)
            ->toast('A reset link has been sent to your email.')
            ->send();
    }
}
