<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
       (1, 'withdrawal_transaction_fee', '5', '2023-02-28 00:00:00', '2023-02-28 00:00:00')
    ");
    }
}
