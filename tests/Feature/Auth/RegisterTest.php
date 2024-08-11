<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;

// TODO: Create admin user for tests
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

        $response->dd();

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);
    }

    #[Test]
    public function it_fails_if_name_and_email_is_not_provided(): void
    {
        $response = $this->response([]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email']);
    }

    private function response(array $data): TestResponse
    {
        $adminUser = User::factory()->create();

        return $this
            ->actingAs($adminUser, 'sanctum')
            ->postJson(route('auth.register'), $data);
    }
}
