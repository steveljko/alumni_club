<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\Auth\ResetPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Response;

final class ResetPasswordController extends Controller
{
    public function __invoke(
        ResetPasswordRequest $request,
        ResetPassword $resetPassword
    ): Response {
        $ok = $resetPassword->execute($request);

        if ($ok) {
            return response(Response::HTTP_NO_CONTENT)
                ->withHeaders([
                    'HX-Redirect' => route('home'),
                    'HX-Trigger' => Json::encode(['toast-after-redirect' => 'Successfully reseted password!']),
                ]);
        }
    }
}
