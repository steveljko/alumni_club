<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function admin_can_successfully_register_new_user(): void
    {
        $response = $this->response([
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);
    }

    #[Test]
    public function it_fails_if_name_and_email_is_not_provided(): void
    {
        $response = $this->response([]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email']);
    }

    #[Test]
    public function it_fails_when_logged_in_user_is_not_admin(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson(route('auth.register'), []);

        $response->assertUnauthorized();
    }

    private function response(array $data): TestResponse
    {
        $user = User::factory()
            ->withRole(UserRole::ADMIN)
            ->create();

        return $this
            ->actingAs($user, 'sanctum')
            ->postJson(route('auth.register'), $data);
    }
}
