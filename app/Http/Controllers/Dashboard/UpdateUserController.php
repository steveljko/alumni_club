<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Response;

final class UpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request, User $user): Response
    {
        $user->update($request->validated());

        return $this->triggerWithToast(event: 'loadUsers', message: 'User succesfully updated!');
    }
}
