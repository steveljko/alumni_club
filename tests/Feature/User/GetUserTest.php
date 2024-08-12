<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Testing\TestResponse;

it('fetches existing user successfully', function () {
    $user = User::factory()->create();

    $response = sendGetUserRequest($user->id);

    expect($response)
        ->toBeOk()
        ->jsonToBe([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
});

it('returns not found when user with incorrect id does not exist', function () {
    $response = sendGetUserRequest(0);

    expect($response)
        ->toBeNotFound()
        ->jsonToBe(['success' => false]);
});

it('applies localization correctly', function () {
    $user = User::factory()->create();
    $response = [];

    App::setLocale('rs');
    $response['rs'] = sendGetUserRequest($user->id);

    App::setLocale('en');
    $response['en'] = sendGetUserRequest($user->id);

    expect($response['en'])
        ->toBeOk()
        ->jsonToBe(['message' => 'User found.']);

    expect($response['rs'])
        ->toBeOk()
        ->jsonToBe(['message' => 'Korisnik uspešno pronađen.']);
});

function sendGetUserRequest(int $id): TestResponse
{
    return sendRequest(
        route: ['users.get', ['user' => $id]],
        type: 'GET',
    );
}
