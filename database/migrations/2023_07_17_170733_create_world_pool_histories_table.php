<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('world_pool_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('worldpoolId');
            $table->string('pool_type');
            $table->double('total_lot');
            $table->bigInteger('total_UM_RM');
            $table->double('net_lot');
            $table->double('pool_commission');
            $table->double('pool_amount');
            $table->dateTime('from_time');
            $table->dateTime('to_time');
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('userId')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

            $table->foreign('worldpoolId')
                ->references('id')
                ->on('world_pool')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('world_pool_histories');
    }
};
