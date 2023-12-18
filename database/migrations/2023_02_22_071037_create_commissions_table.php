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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->double('lot_size', 0, 2)->default(0.00);
            $table->double('commissions_amount', 0, 2)->default(0.00);
            $table->dateTime('transaction_at');
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('brokersId');
            $table->foreign('userId')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');
            $table->foreign('brokersId')
                ->references('id')
                ->on('brokers')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
