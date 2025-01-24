<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Actions\Auth\CreateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use Illuminate\Http\Response;

final class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request, CreateUser $createUser): Response
    {
        $user = $createUser->execute($request);

        return $this->toast('User succesfully created!');
    }
}
