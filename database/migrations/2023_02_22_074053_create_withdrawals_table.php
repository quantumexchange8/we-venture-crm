<?php

use App\Models\Withdrawals;
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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->integer('network');
            $table->double('amount', 0, 2)->default(0.00);
            $table->string('address');
            $table->double('transaction_fee', 0, 2)->default(0.00);
            $table->integer('status')->default(Withdrawals::STATUS_PENDING);
            $table->unsignedBigInteger('requested_by_user');
            $table->foreign('requested_by_user')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('withdrawals');
    }
};
