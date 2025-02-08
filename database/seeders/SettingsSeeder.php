<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::insertOrIgnore([
            ['key' => 'site_name', 'value' => 'Demo Site'],
            ['key' => 'maintenance_mode', 'value' => 'false'],
        ]);
    }
}
