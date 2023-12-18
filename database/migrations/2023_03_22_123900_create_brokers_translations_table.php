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
        Schema::create('brokers_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brokers_id');
            $table->foreign('brokers_id')
                ->references('id')
                ->on('brokers')
                ->onUpdate('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description');
            $table->text('note');
            $table->unique(['brokers_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brokers_translations');
    }
};
