<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_fetches_existing_user_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->response($user->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }

    #[Test]
    public function it_returns_not_found_when_user_with_incorrect_id_does_not_exist(): void
    {
        $response = $this->response(0);

        $response
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(['success' => false]);
    }

    #[Test]
    public function it_applies_localization_correctly(): void
    {
        $user = User::factory()->create();
        $response = [];

        App::setLocale('rs');
        $response['rs'] = $this->response($user->id);

        App::setLocale('en');
        $response['en'] = $this->response($user->id);

        $response['en']
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'User found.']);

        $response['rs']
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Korisnik uspešno pronađen.']);
    }

    private function response(int $id): TestResponse
    {
        return $this->get(route('users.get', ['user' => $id]));
    }
}
