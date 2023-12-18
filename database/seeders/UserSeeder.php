<?php

namespace Database\Seeders;

use App\Models\Rankings;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = '$2y$10$G5QPCuBsGaz2mDApzDdLDek3mTSm181Uink9vaHxVGOEeYEDwLhna';
        $role = User::ROLE_ADMIN;
        $status = User::STATUS_ACTIVE;
        $rankId = Rankings::orderBy('position', "DESC")->first()->id;
        DB::statement("INSERT INTO `users`
	    (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `profile_image`, `contact_number`,
	     `country`, `address`, `referral_id`, `role`, `wallet_balance`, `status`, `auto_rank_up`, `upline_referral_id`, `hierarchyList`, `created_at`, `updated_at`, `deleted_at`, `rankId`)
	VALUES
	    (NULL, 'admin', 'admin@admin.com', NULL, '$password', NULL, NULL, '012-3456789', 'Malaysia', 'Klang Valley', NULL, '$role', 0, '$status', false, NULL, NULL, NOW(), NOW(),NULL, '$rankId')
    ");
    }
}
