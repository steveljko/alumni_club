<?php

namespace Database\Seeders;

use App\Enums\Activity\ActivityEventType;
use App\Enums\Post\PostType;
use App\Http\Actions\Activity\LogUserActivity;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->count(100)
            ->create()
            ->each(function ($post) {
                if ($post->type === PostType::DEFAULT) {
                    $post->default()->create([
                        'body' => fake()->paragraph(),
                    ]);
                }

                if ($post->type === PostType::EVENT) {
                    $post->event()->create([
                        'title' => fake()->sentence(3),
                        'description' => fake()->paragraph(),
                        'event_page_url' => fake()->url(),
                        'start_time' => fake()->dateTimeBetween('now', '+1 month'),
                        'end_time' => fake()->dateTimeBetween('+1 month', '+2 months'),
                        'address' => fake()->streetAddress(),
                        'city' => fake()->city(),
                    ]);
                }

                if ($post->type === PostType::JOB) {
                    $post->job()->create([
                        'position' => fake()->jobTitle(),
                        'description' => fake()->paragraph(),
                        'company_name' => fake()->company(),
                        'company_website_url' => fake()->url(),
                        'company_address' => fake()->streetAddress(),
                        'company_city' => fake()->city(),
                        'start_time' => fake()->dateTimeBetween('now', '+1 month'),
                        'end_time' => fake()->dateTimeBetween('+1 month', '+2 months'),
                        'job_page_url' => fake()->url(),
                    ]);
                }

                (new LogUserActivity)->execute(
                    user: User::find($post->user_id),
                    model: $post,
                    eventType: ActivityEventType::CREATE,
                );

                $commentCount = fake()->numberBetween(1, 5);

                Comment::factory()
                    ->count($commentCount)
                    ->create(['post_id' => $post->id]);
            });
    }
}
