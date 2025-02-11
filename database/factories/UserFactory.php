<?php

namespace Database\Factories;

use App\Enums\Auth\AccountSetupProgress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'password' => static::$password ??= Hash::make('password'),
            'initial_password_changed_at' => now(),
            'setup_progress' => AccountSetupProgress::COMPLETED,
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

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        // Assign role to the user after the user is created.
        return $this->afterCreating(function (User $user) {
            $user->assignRole('alumni');
        });
    }

    /**
     * Sets the user to have an unchanged initial password and marks them at the first setup step.
     */
    public function withUnchangedInitialPassword(): static
    {
        return $this->state(fn () => [
            'initial_password_changed_at' => null,
            'setup_progress' => 'step.1',
        ]);
    }
}
