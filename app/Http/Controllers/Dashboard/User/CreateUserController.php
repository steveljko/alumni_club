<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Actions\Auth\CreateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Response;

final class CreateUserController extends Controller
{
    public function __invoke(
        CreateUserRequest $request,
        CreateUser $createUser
    ): Response {
        if (! auth()->user()->can('create', User::class)) {
            return $this->toast("You don't have permission to execute this action!");
        }

        $createUser->execute($request);

        // Find way to go next page if limit is exeded.
        return $this->triggerWithToast(event: 'loadUsers', message: 'User succesfully created!');
    }
}
