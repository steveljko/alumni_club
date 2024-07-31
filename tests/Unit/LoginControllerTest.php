<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Validation\ValidationException;

class LoginControllerTest extends TestCase
{
    /**
     * @param  array<int,mixed>  $data
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
            'password' => 'password',
        ];
    }

    /**
     * @param  array<int,mixed>  $data
     */
    private static function createRequest(array $data): LoginRequest
    {
        return LoginRequest::create(
            route('auth.login'),
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

        $userResource = (new UserResource($user))->toArray($request);
        unset($userResource['details'], $userResource['jobs']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals([
            'success' => true,
            'message' => __('auth.successful_login'),
            'data' => $userResource,
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

        $this->expectException(ValidationException::class);

        try {
            $controller->__invoke($request);
        } catch (ValidationException $e) {
            $errors = $e->errors();

            $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $e->status);
            $this->assertArrayHasKey('email', $errors);
            $this->assertEquals(__('auth.failed'), $errors['email'][0]);

            throw $e;
        }
    }
}
