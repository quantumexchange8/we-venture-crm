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
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('position');
            $table->integer('standard_lot');
            $table->double('package_requirement', 0, 2)->default(0.00);
            $table->integer('direct_referral');
            $table->string('cultivate_type')->nullable();
            $table->integer('cultivate_member')->nullable();
            $table->double('group_sales', 0, 2)->default(0.00);
            $table->integer('rebate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};
