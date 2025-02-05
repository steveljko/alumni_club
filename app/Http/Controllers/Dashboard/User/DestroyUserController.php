<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Actions\Auth\DeleteUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;

final class DestroyUserController extends Controller
{
    public function __invoke(DeleteUser $deleteUser, User $user): Response
    {
        $deleteUser->execute($user);

        return $this->triggerWithToast(event: 'loadUsers', message: 'User succesfully deleted!');
    }
}
