<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use App\Enums\PostType;
use Illuminate\Testing\TestResponse;

it('deletes post successfully', function () {
    $user = User::factory()->create();

    $post = Post::factory()
        ->withType(PostType::DEFAULT)
        ->withUser($user)
        ->create();

    $response = sendDeletePostRequest(
        user: $user,
        post: $post,
    );

    expect($response)
        ->toBeOk();
});

it('failes when user is not onwer of post', function () {
    $user = User::factory()->create();

    $post = Post::factory()
        ->withType(PostType::DEFAULT)
        ->withUser($user)
        ->create();

    $response = sendDeletePostRequest(
        user: User::factory()->create(),
        post: $post,
    );

    expect($response)
        ->toBeUnauthorized();
});

function sendDeletePostRequest(User $user, Post $post): TestResponse
{
    return sendRequest(
        route: ['posts.delete', ['post' => $post->id]],
        type: 'DELETE',
        withUser: $user,
    );
}
