<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use Illuminate\Testing\TestResponse;

test('admin can successfully register new user', function () {
    $response = sendRegisterRequest([
        'name' => 'New User',
        'email' => 'newuser@example.com',
    ]);

    expect($response)->toBeCreated();

    $this->assertDatabaseHas('users', [
        'name' => 'New User',
        'email' => 'newuser@example.com',
    ]);
});

it('fails if name and email is not provided', function () {
    $response = sendRegisterRequest([]);

    expect($response)
        ->toBeUnprocessable()
        ->toHaveValidationErrors(['name', 'email']);
});

it('fails when logged in user is not admin', function () {
    $response = sendRequest(
        route: 'auth.register',
        type: 'POST',
        data: [],
        withUser: true,
    );

    expect($response)->toBeUnauthorized();
});

function sendRegisterRequest(array $data): TestResponse
{
    return sendRequest(
        route: 'auth.register',
        type: 'POST',
        data: $data,
        withUser: [true, UserRole::ADMIN],
    );
}
