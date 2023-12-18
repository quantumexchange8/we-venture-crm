<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('profile_image')->nullable();
            $table->string('contact_number', 50);
            $table->string('country', 50);
            $table->string('address');
            $table->string('referral_id')->nullable();
            $table->integer('role')->default(User::ROLE_MEMBER);
            $table->double('wallet_balance', 0, 2)->default(0.00);
            $table->integer('status')->default(User::STATUS_ACTIVE);
            $table->integer('rank')->nullable();
            $table->boolean('auto_rank_up')->default(false);
            $table->string('hierarchyList')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
