<?php

namespace Tests\Feature\Post;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_new_default_post_successfully(): void
    {
        $response = $this->response('default', [
            'status' => 'published',
            'type' => 'default',
            'body' => 'This is just an example...',
        ]);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
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
    }

    #[Test]
    public function it_creates_new_event_post_successfully(): void
    {
        $response = $this->response('event', [
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

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
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
    }

    #[Test]
    public function it_creates_new_job_post_successfully(): void
    {
        $response = $this->response('job', [
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

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
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
    }

    private function response(string $type, array $params = []): TestResponse
    {
        $user = User::factory()->create();

        return $this
            ->actingAs($user, 'sanctum')
            ->postJson(route("posts.create.$type"), $params);
    }
}
