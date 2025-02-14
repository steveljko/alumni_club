<?php

namespace App\Http\Actions\Auth;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class CreateUser
{
    public function execute(CreateUserRequest $request)
    {
        $password = Str::random(12);

        $user = User::create(array_merge($request->validated(), [
            'password' => Hash::make($password),
        ]));

        Mail::to($user->email)
            ->send(new SendPasswordToNewlyCreatedUserMail($password));
    }
}
