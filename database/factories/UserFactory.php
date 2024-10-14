<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'email_visible' => true,
            'role' => UserRole::DEFAULT,
            'initial_password_changed' => true,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withRole(UserRole $role): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => $role,
        ]);
    }

    public function withUnchangedInitialPassword(): static
    {
        return $this->state(fn () => ['initial_password_changed' => false]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->details()->update([
                'date_of_birth' => fake()->dateTimeBetween('-100 years', '-18 years'),
                'gender' => fake()->randomElement(['male', 'female']),
                'phone_number' => fake()->phoneNumber(),
                'phone_number_visible' => fake()->boolean(),
                'uni_start_year' => fake()->year(max: 'now'),
                'uni_finish_year' => fake()->year(max: 'now'),
                'bio' => fake()->paragraph(),
                'changed' => false,
            ]);
        });
    }
}
