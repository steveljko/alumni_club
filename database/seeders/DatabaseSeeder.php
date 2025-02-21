<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** @var bool */
    protected static $running = false;

    /**
     * Checks if database seeder is running or not
     */
    public static function isRunning(): bool
    {
        return static::$running;
    }

    /**
     * Start seeder
     */
    public static function start(): void
    {
        static::$running = true;
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        self::start();

        $this->call([
            SettingsSeeder::class,
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            PostsSeeder::class,
        ]);
    }
}
