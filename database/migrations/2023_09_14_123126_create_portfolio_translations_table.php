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
        Schema::create('portfolio_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');
            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolios')
                ->onUpdate('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description');
            $table->unique(['portfolio_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_translations');
    }
};
