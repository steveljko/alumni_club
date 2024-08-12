<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Testing\TestResponse;

it('filters by exact name', function () {
    User::factory(20)->create();
    $user = User::factory()->create(['name' => 'John Doe']);

    $response = sendGetUsersRequest(['name' => ['eq' => 'John Doe']]);

    expect($response)
        ->toBeOk()
        ->jsonToBe([
            'data' => [
                'data' => [
                    ['name' => 'John Doe'],
                ],
            ],
        ]);
});

it('fails when users are not found with this criteria', function () {
    User::factory()->create(['name' => 'Jane Doe']);

    $response = sendGetUsersRequest(['name' => ['eq' => 'John Doe 2']]);

    expect($response)
        ->toBeNotFound()
        ->jsonToBe([
            'success' => false,
        ]);
});

it('filters by relationship correctly', function () {
    User::factory(20)->create();
    $user = User::factory()->create(['name' => 'John Doe']);
    $user->details()->update(['uni_start_year' => 2020, 'uni_finish_year' => 2023]);

    $response = sendGetUsersRequest([
        'details.uni_start_year' => ['gte' => 2020],
        'details.uni_finish_year' => ['lte' => 2023],
    ]);

    expect($response)
        ->toBeOk()
        ->jsonToBe([
            'data' => [
                'data' => [
                    [
                        'name' => 'John Doe',
                        'details' => [
                            'uni_start_year' => 2020,
                            'uni_finish_year' => 2023,
                        ],
                    ],
                ],
            ],
        ]);
});

function sendGetUsersRequest(array $params = []): TestResponse
{
    return sendRequest(
        route: ['users.all', $params],
        type: 'GET',
    );
}
