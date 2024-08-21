<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Testing\TestResponse;

it('returns logged in user correctly', function () {
    $user = User::factory()->create();

    $response = sendGetUserRequest($user);

    expect($response)
        ->toBeOk()
        ->jsonToBe([
            'success' => true,
            'message' => __('auth.successful_user_fetch'),
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

it('returns user data with correct role', function () {
    $adminUser = User::factory()->withRole(UserRole::ADMIN)->create();
    $response = sendGetUserRequest($adminUser);

    expect($response)
        ->toBeOk()
        ->jsonToBe([
            'success' => true,
            'data' => [
                'role' => 'admin',
            ],
        ]);
});

it('fails when user is not authenticated', function () {
    $response = sendGetUserRequest(user: false);

    expect($response)
        ->toBeUnauthorized()
        ->jsonToBe([
            'success' => false,
            'message' => __('auth.unauthenticated'),
        ]);
});

function sendGetUserRequest(User|bool $user): TestResponse
{
    return sendRequest(
        route: 'auth.user',
        type: 'GET',
        withUser: $user,
    );
}
