<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->json('selected_users')->nullable()->after('event_image');
            $table->json('user_ids')->nullable()->after('selected_users');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
