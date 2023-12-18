<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('world_pool', function (Blueprint $table) {
            $table->id();
            $table->string('pool_type', 50);
            $table->double('total_lot');
            $table->bigInteger('total_UM');
            $table->bigInteger('total_RM');
            $table->double('avg_lot');
            $table->dateTime('from_time')->nullable();
            $table->dateTime('to_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('world_pool');
    }
};
