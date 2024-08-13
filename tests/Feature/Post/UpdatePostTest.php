<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use App\Enums\PostType;
use Illuminate\Support\Facades\App;
use Illuminate\Testing\TestResponse;

it('updates default post successfully', function () {
    $user = User::factory()->create();

    $post = Post::factory()
        ->withType(PostType::DEFAULT)
        ->withUser($user)
        ->create();

    $response = sendUpdatePostRequest(
        user: $user,
        id: $post->id,
        data: [
            'body' => 'Updated Body',
        ]
    );

    expect($response)
        ->toBeOk()
        ->toHaveJsonStructure([
            'data' => [
                'id',
                'status',
                'type',
                'likes_count',
                'user' => ['id', 'name', 'email'],
                'created_at',
                'data' => ['body'],
            ],
        ])
        ->jsonToBe([
            'success' => true,
            'data' => [
                'type' => 'default',
                'data' => [
                    'body' => 'Updated Body',
                ],
            ],
        ]);
});

it('updates event post successfully', function () {
    $user = User::factory()->create();

    $post = Post::factory()
        ->withType(PostType::EVENT)
        ->withUser($user)
        ->create();

    $response = sendUpdatePostRequest(
        user: $user,
        id: $post->id,
        data: [
            'title' => 'Updated Example Event',
            'description' => 'This is example event.',
            'event_page_url' => 'https://www.example.com',
            'start_time' => now(),
            'end_time' => now()->addMinutes(10),
            'address' => 'Test Address',
            'city' => 'Test City',
        ]
    );

    expect($response)
        ->toBeOk()
        ->toHaveJsonStructure([
            'data' => [
                'id',
                'status',
                'type',
                'likes_count',
                'user' => ['id', 'name', 'email'],
                'created_at',
                'data' => [
                    'title', 'description', 'event_page_url',
                    'start_time', 'end_time', 'address', 'city',
                ],
            ],
        ])
        ->jsonToBe([
            'success' => true,
            'data' => [
                'type' => 'event',
                'data' => [
                    'title' => 'Updated Example Event',
                ],
            ],
        ]);
});

it('updates job post successfully', function () {
    $user = User::factory()->create();

    $post = Post::factory()
        ->withType(PostType::JOB)
        ->withUser($user)
        ->create();

    $response = sendUpdatePostRequest(
        user: $user,
        id: $post->id,
        data: [
            'position' => 'Updated Example Position',
            'description' => 'This is example for position.',
            'company_name' => 'Example Company',
            'company_city' => 'Example City',
            'opening_start' => now(),
            'opening_end' => now()->addMonths(1),
            'job_page_url' => 'https://www.example.com',
        ]
    );

    expect($response)
        ->toBeOk()
        ->toHaveJsonStructure([
            'data' => [
                'id',
                'status',
                'type',
                'likes_count',
                'user' => ['id', 'name', 'email'],
                'created_at',
                'data' => [
                    'position', 'description',
                    'company_name', 'company_city',
                    'opening_start', 'opening_end',
                    'job_page_url',
                ],
            ],
        ])
        ->jsonToBe([
            'data' => [
                'data' => [
                    'position' => 'Updated Example Position',
                ],
            ],
        ]);
});

it('restrics update if user is not owner of post', function () {
    $post = Post::factory()
        ->withType(PostType::JOB)
        ->withUser(User::factory()->create())
        ->create();

    $response = sendUpdatePostRequest(
        User::factory()->create(),
        $post->id,
        []
    );

    expect($response)
        ->toBeUnauthorized()
        ->jsonToBe(['success' => false]);
});

it('applies localization correctly', function ($lang) {
    $user = User::factory()->create();

    $post = Post::factory()
        ->withType(PostType::DEFAULT)
        ->withUser($user)
        ->create();

    App::setLocale($lang);

    $response = sendUpdatePostRequest(
        user: $user,
        id: $post->id,
        data: ['body' => 'Updated Body']
    );

    expect($response)
        ->toBeOk()
        ->jsonToBe(['message' => __('additional.posts.successful_update')]);

    $response = sendUpdatePostRequest(
        user: User::factory()->create(),
        id: $post->id,
        data: ['body' => 'Updated Body']
    );

    expect($response)
        ->toBeUnauthorized()
        ->jsonToBe(['message' => __('additional.posts.failed_update')]);
})->with(['en', 'rs']);

function sendUpdatePostRequest(User $user, int $id, array $data): TestResponse
{
    return sendRequest(
        route: ['posts.update', ['post' => $id]],
        type: 'PUT',
        data: $data,
        withUser: $user
    );
}
