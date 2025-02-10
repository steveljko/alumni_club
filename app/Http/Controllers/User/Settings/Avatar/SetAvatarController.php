<?php

namespace App\Http\Controllers\User\Settings\Avatar;

use App\Http\Actions\Auth\SetAvatar;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAvatarRequest;
use Illuminate\Http\Response;

final class SetAvatarController extends Controller
{
    public function __invoke(
        UploadAvatarRequest $request,
        SetAvatar $setAvatar,
    ): Response {
        $ok = $setAvatar->execute(request: $request, user: auth()->user());

        if (! $ok) {
            $this->toast(__('auth.try_again'));
        }

        return $this->redirectWithToast(
            route: 'users.settings',
            message: __('auth.succesful_avatar_upload'),
        );
    }
}
