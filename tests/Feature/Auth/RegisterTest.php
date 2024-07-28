<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
  use RefreshDatabase;

  const ADMIN='admin';
  const DEFAULT='default';

  private function generateUser(string $type = ''): User
  {
    if ($type === self::ADMIN) {
      $user = User::factory()->create();
      $role = Role::firstOrCreate(['name' => 'admin']);
      $user->assignRole($role);
      return $user;
    } else if ($type === self::DEFAULT) {
      $user = User::factory()->create();
      $role = Role::firstOrCreate(['name' => 'default']);
      $user->assignRole($role);
    } else {
      throw new \Exception("This type doesn't exist!", 1);
    }
  }

  #[Test]
  public function admin_can_successfully_register_new_user(): void
  {
    $adminUser = $this->generateUser(self::ADMIN);

    $response = $this->actingAs($adminUser)
      ->post(route('auth.register'), [
        'name' => 'New User',
        'email' => 'newuser@example.com',
      ]);

    $response->assertStatus(Response::HTTP_CREATED);

    $this->assertDatabaseHas('users', [
      'email' => 'newuser@example.com',
    ]);
  }

  #[Test]
  public function it_fails_if_name_and_email_is_not_provided(): void
  {
    $adminUser = $this->generateUser(self::ADMIN);

    $resp = $this
      ->actingAs($adminUser)
      ->json('POST', route('auth.register'), []);

    $resp->assertStatus(422);
    $resp->assertJsonValidationErrors(['name', 'email']);
  }
}
