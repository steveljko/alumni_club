<?php

namespace Tests\Feature\Post;

use App\Models\PostEvent;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Storage;

it('creates new default post successfully', function () {
    $response = sendCreatePostRequest('default', [
        'status' => 'published',
        'type' => 'default',
        'body' => 'This is just an example...',
    ]);

    expect($response)
        ->toBeCreated()
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
        ]);
});

it('creates new event post successfully', function () {
    $response = sendCreatePostRequest('event', [
        'status' => 'published',
        'type' => 'event',
        'title' => 'Example Event',
        'description' => 'This is example event.',
        'event_page_url' => 'https://www.example.com',
        'start_time' => now(),
        'end_time' => now()->addMinutes(10),
        'address' => 'Test Address',
        'city' => 'Test City',
    ]);

    expect($response)
        ->toBeCreated()
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
        ]);

    expect($response['data']['data']['thumbnail_image'])->toBe(null);
});

it('creates new event post with image successfully', function () {
    Storage::fake('public');
    $file = UploadedFile::fake()->image('event.jpg');

    $response = sendCreatePostRequest('event', [
        'status' => 'published',
        'type' => 'event',
        'title' => 'Example Event',
        'description' => 'This is example event.',
        'event_page_url' => 'https://www.example.com',
        'start_time' => now(),
        'end_time' => now()->addMinutes(10),
        'address' => 'Test Address',
        'city' => 'Test City',
        'thumbnail_image' => $file,
    ]);

    expect($response)
        ->toBeCreated()
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
        ]);

    expect($response['data']['data']['thumbnail_image'])->not->toBe(null);

    $this->assertDatabaseHas('images', [
        'model_type' => PostEvent::class,
        'model_id' => $response['data']['id'],
        'type' => 'thumbnail_image',
    ]);
});

it('creates new job post successfully', function () {
    $response = sendCreatePostRequest('job', [
        'status' => 'published',
        'type' => 'job',
        'position' => 'Example Position',
        'description' => 'This is example for position.',
        'company_name' => 'Example Company',
        'company_city' => 'Example City',
        'opening_start' => now(),
        'opening_end' => now()->addMonths(1),
        'job_page_url' => 'https://www.example.com',
    ]);

    expect($response)
        ->toBeCreated()
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
        ]);
});

function sendCreatePostRequest(string $type, array $data = []): TestResponse
{
    return sendRequest(
        route: "posts.create.$type",
        type: 'POST',
        data: $data,
        withUser: true,
    );
}
