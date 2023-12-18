<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Settings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RankingsSeeder::class,
            UserSeeder::class,
            BrokersSeeder::class,
            SettingsSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
