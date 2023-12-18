<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("INSERT INTO `rankings` (`id`, `name`, `position`, `standard_lot`, `package_requirement`, `direct_referral`, `cultivate_type`, `cultivate_member`, `group_sales`, `rebate`, `created_at`, `updated_at`) VALUES
       (1, 'Introducing Broker', 1, 8, 1000.00, 3, NULL, NULL, 5000.00, 0, '2023-02-22 17:00:00', '2023-02-22 17:00:00'),
       (2, 'Senior Introducing Broker', 2, 11, 5000.00, 4, 'IB', 3, 30000.00, 0, '2023-02-22 17:00:00', '2023-02-22 17:00:00'),
       (3, 'Master Introducing Broker', 3, 14, 10000.00, 5, 'SIB', 3, 150000.00, 0, '2023-02-22 17:00:00', '2023-02-22 17:00:00'),
       (4, 'Unit Manager', 4, 17, 30000.00, 6, 'MIB', 4, 750000.00, 5, '2023-02-22 17:00:00', '2023-02-22 17:00:00'),
       (5, 'Regional Manager', 5, 20, 50000.00, 8, 'UM', 4, 3000000.00, 5, '2023-02-22 17:00:00', '2023-02-22 17:00:00')
       ");
    }
}
