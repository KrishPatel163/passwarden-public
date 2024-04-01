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
        Schema::create('password_create_audit', function (Blueprint $table) {
            $table->string('audit_id', 255)->primary();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('password_id')->constrained('users_passwords')->onDelete('no action');
            $table->string('website');
            $table->string('account_name');
            $table->string('password');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_create_audit');
    }
};
