<?php

namespace Tests\Feature\Auth;

use Hash;
use App\Models\User;
use Illuminate\Testing\TestResponse;

it('changes password successfully', function () {
    $user = User::factory()->create();
    $user->password = Hash::make('mypassword');
    $user->save();

    $response = sendChangePasswordRequest(user: $user, data: [
        'current_password' => 'mypassword',
        'password' => 'asd123123',
        'password_confirmation' => 'asd123123',
    ]);

    expect($response)->toBeOk();
});

it('fails when current password is not correct', function () {
    $user = User::factory()->create();
    $user->password = Hash::make('mypassword');
    $user->save();

    $response = sendChangePasswordRequest(user: $user, data: [
        'current_password' => 'mypasswords',
        'password' => 'asd123123',
        'password_confirmation' => 'asd123123',
    ]);

    expect($response)->validationToFailWithFields(['current_password']);
});

it('fails when user is attempt to change password, but initial password is not originally changed', function () {
    $user = User::factory()->withUnchangedInitialPassword()->create();

    $response = sendChangePasswordRequest(user: $user, data: [
        'current_password' => 'mypasswords',
        'password' => 'asd123123',
        'password_confirmation' => 'asd123123',
    ]);

    expect($response)->toBeForbidden();
});

function sendChangePasswordRequest(User $user, array $data = []): TestResponse
{
    return sendRequest(
        route: 'auth.change_password',
        type: 'PUT',
        data: $data,
        withUser: $user,
    );
}
