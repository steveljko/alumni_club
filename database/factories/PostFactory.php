<?php

namespace Database\Factories;

use App\Enums\Post\PostStatus;
use App\Enums\Post\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => PostStatus::PUBLISHED->value,
            'type' => fake()->randomElement(PostType::cases())->value,
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'user_id' => \App\Models\User::all()->random()->id,
        ];
    }
}
