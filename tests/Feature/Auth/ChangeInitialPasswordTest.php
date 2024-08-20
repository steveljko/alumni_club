<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Testing\TestResponse;

it('changes initial password successfully', function () {
    $user = User::factory()->withUnchangedInitialPassword()->create();

    $response = sendChangeInitialPasswordRequest(user: $user, data: [
        'password' => 'asd123123',
        'password_confirmation' => 'asd123123',
    ]);

    expect($response)
        ->toBeOk()
        ->jsonToBe([
            'success' => true,
            'message' => __('auth.initial_password_change.successful'),
        ]);
});

it('fails when initial password is already changed', function () {
    $user = User::factory()->create();

    $response = sendChangeInitialPasswordRequest(user: $user, data: [
        'password' => 'asd123123',
        'password_confirmation' => 'asd123123',
    ]);

    expect($response)
        ->toBeForbidden()
        ->jsonToBe([
            'success' => false,
            'message' => __('auth.initial_password_change.failed'),
        ]);
});

function sendChangeInitialPasswordRequest(User $user, array $data = []): TestResponse
{
    return sendRequest(
        route: 'auth.change_initial_password',
        type: 'PUT',
        data: $data,
        withUser: $user,
    );
}
