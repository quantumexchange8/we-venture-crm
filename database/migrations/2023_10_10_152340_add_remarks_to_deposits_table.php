<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('remarks')->nullable()->after('transaction_at');
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            //
        });
    }
};
