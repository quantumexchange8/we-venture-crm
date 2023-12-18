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
            $ranks = Rankings::all();
            foreach ($ranks as $rank) {
                $shortform = "";

                if ($rank->name == "Trader") {
                    $shortform = "Trader";
                } else {
                    $tempName = explode(" ", $rank->name);
                    for ($i = 0; $i < sizeof($tempName); $i++) {
                        $shortform = $shortform . substr($tempName[$i], 0, 1);
                    }
                }
                $rank->rank_short_form = $shortform;
                $rank->save();
            }
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
