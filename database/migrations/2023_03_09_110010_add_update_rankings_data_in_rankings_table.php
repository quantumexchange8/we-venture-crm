<?php

use App\Models\Rankings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $old_ranks = Rankings::all();
            foreach ($old_ranks as $rank) {
                $rank->position += 1;
                $rank->save();
            }

            Rankings::create([
                'name' => 'Trader',
                'position' => 1,
                'standard_lot' => 0,
                'package_requirement' => 0,
                'direct_referral' => 0,
                'cultivate_type' => NULL,
                'cultivate_member' => NULL,
                'group_sales' => 0,
                'rebate' => 0,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            //
        });
    }
};
