<?php

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Testing\TestResponse;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

// Http statuses
expect()->extend('toBeOk', function () {
    return $this->assertOk();
});

expect()->extend('toBeCreated', function () {
    return $this->assertCreated();
});

expect()->extend('toBeUnprocessable', function () {
    return $this->assertUnprocessable();
});

expect()->extend('toBeUnauthorized', function () {
    return $this->assertUnauthorized();
});

expect()->extend('toBeNotFound', function () {
    return $this->assertNotFound();
});

// Json validation
expect()->extend('toHaveJsonStructure', function ($data) {
    return $this->assertJsonStructure($data);
});

expect()->extend('toHaveValidationErrors', function ($data) {
    return $this->assertJsonValidationErrors($data);
});

expect()->extend('jsonToBe', function ($data) {
    return $this->assertJson($data);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function sendRequest(
    string|array $route,
    string $type,
    ?array $data = null,
    bool|array|User|null $withUser = null
): TestResponse {
    if ($withUser) {
        $user = ! ($withUser instanceof User) ?
            User::factory()
                ->withRole($withUser[1] ?? UserRole::DEFAULT)
                ->create() :
            $withUser;

        test()->actingAs($user, 'sanctum');
    }

    $url = is_string($route) ?
        route($route) :
        route(array_shift($route), ...$route);

    switch ($type) {
        case 'GET':
            return test()->getJson($url);
            break;
        case 'POST':
            return test()->postJson($url, $data);
            break;
        case 'PATCH':
            return test()->patchJson($url, $data);
            break;
        case 'PUT':
            return test()->putJson($url, $data);
            break;
        case 'DELETE':
            return test()->deleteJson($url, $data);
            break;
    }
}
