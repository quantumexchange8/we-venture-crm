<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('leader_status')->default(false)->after('hierarchyList');
        });

    $leader_emails = ['kohyuqing994@gmail.com','davchea6@gmail.com','dnyleow6262@gmail.com',
        'Hungerbossgroup@gmail.com','alice11ssk@gmail.com','wcldarrenlee@gmail.com',
        'huiwenyew@gmail.com','Jacekok.longasia@gmail.com'];

    $users = User::whereIn('email', $leader_emails)->get();
        foreach($users as $user) {
            $user->leader_status = true;
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('leader_status');
        });
    }
};
