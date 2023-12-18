<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrokersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("INSERT INTO `brokers` (`id`, `name`, `description`, `note`, `url`, `broker_image`, `qr_image`, `userId`, `created_at`, `updated_at`) VALUES
       (1, 'Test', 'Test', 'Test', 'Test', 'Test', 'Test', 1, '2023-02-22 17:00:00', '2023-02-22 17:00:00')
    ");
    }
}
