<?php

namespace App\Http\Controllers\User\Settings\Avatar;

use App\Http\Actions\Auth\ResetAvatar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class ResetAvatarController extends Controller
{
    public function __invoke(ResetAvatar $resetAvatar): Response
    {
        $ok = $resetAvatar->execute(user: auth()->user());

        if (! $ok) {
            $this->toast(__('auth.try_again'));
        }

        return $this->redirectWithToast(
            route: 'auth.settings',
            message: __('auth.succesful_avatar_reset')
        );
    }
}
