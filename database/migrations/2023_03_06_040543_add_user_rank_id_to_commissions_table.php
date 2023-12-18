<?php

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
        Schema::table('commissions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_rankId')->after('transaction_at');
            $table->foreign('user_rankId')
                ->references('id')
                ->on('rankings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->dropForeign(['user_rankId']);
            $table->dropColumn('user_rankId');
        });
    }
};
