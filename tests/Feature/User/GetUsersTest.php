<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Response;
use App\Models\User;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
  use RefreshDatabase;

  #[Test]
  public function it_filters_by_exact_name(): void
  {
    $user = User::factory()->create(['name' => 'John Doe']);

    $response = $this->get(route('users.get', ['name' => ['eq' => 'John Doe']]));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJson([
        'data' => [
          'data' => [
            ['name' => 'John Doe']
          ],
        ]
      ]);
  }

  #[Test]
  public function it_fails_when_users_are_not_found_with_this_criteria(): void
  {
    User::factory()->create(['name' => 'Jane Doe']);

    $response = $this->get(route('users.get', ['name' => ['eq' => 'John Doe 2']]));

    $response->assertStatus(Response::HTTP_NOT_FOUND)
      ->assertJson([
        'success' => false,
      ]);
  }

  #[Test]
  public function it_filters_by_relationship_correctly(): void
  {
    User::factory(20)->create();
    $user = User::factory()->create(['name' => 'John Doe']);
    $user->details()->update(['uni_start_year' => '2020', 'uni_finish_year' => '2023']);

    $response = $this->get(route('users.get', [
      '(details_uni_start_year)' => ['gte' => '2020'],
      '(details_uni_finish_year)' => ['lte' => '2023'],
    ]));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJson([
        'data' => [
          'data' => [
            [
              'name' => 'John Doe',
              'details' => [
                'uni_start_year' => '2020',
                'uni_finish_year' => '2023',
              ]
            ]
          ],
        ]
      ]);
  }
}
