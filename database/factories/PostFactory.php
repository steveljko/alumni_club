<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Enums\PostType;
use App\Enums\PostStatus;
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
            'status' => $this->randomEnumValue(PostStatus::class),
            'type' => $this->randomEnumValue(PostType::class),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {
            if ($post->type->value == 'default') {
                $post->default()->create([
                    'body' => fake()->text(100),
                ]);
            } elseif ($post->type->value == 'event') {
                $post->event()->create([
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'event_page_url' => fake()->url(),
                    'start_time' => now(),
                    'end_time' => now()->addMinutes(10),
                    'address' => fake()->address(),
                    'city' => fake()->city,
                ]);
            } elseif ($post->type->value == 'job') {
                $post->job()->create([
                    'position' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'company_name' => fake()->name(),
                    'company_city' => fake()->city(),
                    'opening_start' => now(),
                    'opening_end' => now()->addMonths(1),
                    'job_page_url' => fake()->url(),
                ]);
            }
        });
    }

    public function withType(PostType $type)
    {
        return $this->state([
            'type' => $type->value,
        ]);
    }

    public function withUser(User $user)
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    /**
     * Get a random value from an enum class.
     */
    protected function randomEnumValue(string $enumClass): string
    {
        $cases = $enumClass::cases();
        $randomCase = $cases[array_rand($cases)];

        return $randomCase->value;
    }
}
