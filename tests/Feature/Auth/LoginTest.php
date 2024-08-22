<?php

namespace Tests\Feature\Auth;

use App\Models\User;

it('logs in successfully', function () {
    $user = User::factory()->create();

    $response = sendLoginRequest(data: [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect($response)
        ->toBeOk()
        ->jsonToBe([
            'success' => true,
        ]);
});

it('fails when password is wrong', function () {
    $user = User::factory()->create();

    $response = sendLoginRequest(data: [
        'email' => $user->email,
        'password' => 'asdasdasd',
    ]);

    expect($response)
        ->validationToFailWithFields(['email']);
});

it('fails when email and password are wrong', function () {
    $response = sendLoginRequest(data: [
        'email' => 'test@test.com',
        'password' => 'asdasdasd',
    ]);

    expect($response)
        ->validationToFailWithFields(['email']);
});

function sendLoginRequest(array $data)
{
    return sendRequest(
        route: 'auth.login',
        type: 'POST',
        data: $data,
    );
}
