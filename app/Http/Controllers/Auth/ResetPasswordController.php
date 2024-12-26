<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HtmxResponse;
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

        if ($ok) {
            return (new HtmxResponse)
                ->redirectTo('home')
                ->toast('Successfully reseted password!')
                ->send();
        }
    }
}
