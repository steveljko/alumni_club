<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(50)
            ->has(WorkHistory::factory(3))
            ->create(['setup_progress' => 'completed']);

        User::factory()
            ->create(['email' => 'admin@admin.com'])
            ->assignRole('admin');

        User::factory()
            ->create(['email' => 'user@user.com'])
            ->assignRole('alumni');
    }
}
