<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;

class LoginControllerTest extends TestCase
{
    /**
     * @param array<int,mixed> $data
     */
    private static function makeUser(array $data = []): User
    {
        return User::factory()->make($data);
    }

    /**
     * @return array<string,mixed>
     */
    private static function data(User $user): array
    {
        return [
            'email' => $user->email,
            'password' => 'password'
        ];
    }
    /**
     * @param array<int,mixed> $data
     */
    private static function createRequest(array $data): LoginRequest
    {
        return LoginRequest::create(
            route('login'),
            'POST',
            $data
        );
    }

    public function test_login_method_returns_success_with_valid_credentials(): void
    {
        $user = $this->makeUser(['email' => 'test@example.com']);

        $params = $this->data($user);

        $request = $this->createRequest($params);

        Auth::shouldReceive('attempt')
            ->once()
            ->with($params)
            ->andReturn(true);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $controller = new LoginController();
        $response = $controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals([
            "success" => true,
            "user" => $user->toArray()
        ], $response->getData(true));
    }

    public function test_login_method_returns_forbidden_with_invalid_credentials(): void
    {
        $params = ['email' => 'test@example.com', 'password' => 'password'];

        $request = $this->createRequest($params);

        Auth::shouldReceive('attempt')
            ->once()
            ->with($params)
            ->andReturn(false);

        $controller = new LoginController();
        $response = $controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals([
            "success" => false,
            "message" => "Invalid email or password. Please check your credentials and try again."
        ], $response->getData(true));
    }
}
