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
        Schema::table('password_create_audit', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['password_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_create_audit', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('password_id')->constrained('users_passwords');
        });
    }
};
