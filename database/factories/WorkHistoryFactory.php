<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'position' => fake()->jobTitle(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'description' => fake()->text(),
        ];
    }
}
