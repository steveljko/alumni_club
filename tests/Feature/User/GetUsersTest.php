<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_filters_by_exact_name(): void
    {
        User::factory(20)->create();
        $user = User::factory()->create(['name' => 'John Doe']);

        $response = $this->response(['name' => ['eq' => 'John Doe']]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'data' => [
                        ['name' => 'John Doe'],
                    ],
                ],
            ]);
    }

    #[Test]
    public function it_fails_when_users_are_not_found_with_this_criteria(): void
    {
        User::factory()->create(['name' => 'Jane Doe']);

        $response = $this->response(['name' => ['eq' => 'John Doe 2']]);

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
        $user->details()->update(['uni_start_year' => 2020, 'uni_finish_year' => 2023]);

        $response = $this->response([
            'details.uni_start_year' => ['gte' => 2020],
            'details.uni_finish_year' => ['lte' => 2023],
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
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
    }

    /**
     * @param  array<int,mixed>  $params
     */
    private function response(array $params = []): TestResponse
    {
        return $this->get(route('users.all', $params));
    }
}
