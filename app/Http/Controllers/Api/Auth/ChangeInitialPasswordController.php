<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\SetNewPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\Group;
use App\Exceptions\InitialPasswordAlreadyChanged;
use App\Http\Requests\Auth\ChangeInitialPasswordRequest;

#[Group('Auth')]
class ChangeInitialPasswordController extends Controller
{
    /**
     * Change initial password
     *
     * This endpoint is used only for changing user's initial password.
     *
     * @authenticated
     *
     * @var \App\Http\Requests\Auth\ChangeInitialPasswordRequest
     * @var \App\Services\SetNewPassword
     */
    public function __invoke(ChangeInitialPasswordRequest $request, SetNewPassword $service): JsonResponse
    {
        try {
            if ($service(user: Auth::user(), request: $request)) {
                Log::info('User {name} with ID {id} successfully changed their initial registration password.', ['name' => Auth::user()->name, 'id' => Auth::user()->id]);

                return $this->sendOk(key: 'auth.initial_password_change.successful');
            }
        } catch (InitialPasswordAlreadyChanged $ex) {
            Log::warning('User {name} with ID {id} attempted to change their already changed initial password.', ['name' => Auth::user()->name, 'id' => Auth::user()->id]);
            throw $ex;
        }
    }
}
