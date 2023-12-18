<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('front_id_image')->nullable()->after('leader_status');
                $table->string('back_id_image')->nullable()->after('front_id_image');
            $table->integer('kyc_approval_status')->default(User::KYC_STATUS_NOT_VERIFY)->after('back_id_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
