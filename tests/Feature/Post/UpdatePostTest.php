<?php

namespace Tests\Feature\Post;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Enums\PostType;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    /**
     * Call this template method before each test method is run.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function it_updates_default_post_successfully(): void
    {
        $post = Post::factory()
            ->withType(PostType::DEFAULT)
            ->withUser($this->user)
            ->create();

        $response = $this->response($post->id, [
            'body' => 'Updated Body',
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
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
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'type' => 'default',
                    'data' => [
                        'body' => 'Updated Body',
                    ],
                ],
            ]);
    }

    #[Test]
    public function it_updates_event_post_successfully(): void
    {
        $post = Post::factory()
            ->withType(PostType::EVENT)
            ->withUser($this->user)
            ->create();

        $response = $this->response($post->id, [
            'title' => 'Updated Example Event',
            'description' => 'This is example event.',
            'event_page_url' => 'https://www.example.com',
            'start_time' => now(),
            'end_time' => now()->addMinutes(10),
            'address' => 'Test Address',
            'city' => 'Test City',
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
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
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'type' => 'event',
                    'data' => [
                        'title' => 'Updated Example Event',
                    ],
                ],
            ]);
    }

    #[Test]
    public function it_updates_job_post_successfully(): void
    {
        $post = Post::factory()
            ->withType(PostType::JOB)
            ->withUser($this->user)
            ->create();

        $response = $this->response($post->id, [
            'position' => 'Updated Example Position',
            'description' => 'This is example for position.',
            'company_name' => 'Example Company',
            'company_city' => 'Example City',
            'opening_start' => now(),
            'opening_end' => now()->addMonths(1),
            'job_page_url' => 'https://www.example.com',
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
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
            ])
            ->assertJson([
                'data' => [
                    'data' => [
                        'position' => 'Updated Example Position',
                    ],
                ],
            ]);
    }

    private function response(int $id, array $params = []): TestResponse
    {
        return $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(route('posts.update', ['post' => $id]), $params);
    }
}
