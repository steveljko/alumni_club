<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(WorkHistory::factory(3))
            ->create(['setup_progress' => 'completed']);
    }
}
