<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->json('selected_users')->nullable()->after('min_amount');
            $table->json('user_ids')->nullable()->after('selected_users');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            //
        });
    }
};
