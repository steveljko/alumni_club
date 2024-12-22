<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\Auth\ForgotPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Response;

final class ForgotPasswordController extends Controller
{
    public function __invoke(
        ForgotPasswordRequest $request,
        ForgotPassword $forgotPassword,
    ): Response {
        $forgotPassword->execute($request);

        return response(Response::HTTP_NO_CONTENT)
            ->header('HX-Trigger',
                Json::encode(['toast' => 'A reset link has been sent to your email.']));
    }
}
