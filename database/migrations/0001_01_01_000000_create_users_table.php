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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('nick_name', 100)->nullable();
            $table->string('user_name', 100); // Unique per user. Used when the user wants to share his profile link.
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('country_code', 10)->nullable();
            $table->string('phone', 30)->nullable();
            $table->json('location')->nullable();
            $table->string('email');
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('has_auth_account')->default(false);
            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_phone_verified')->default(false);
            $table->unsignedInteger('login_count')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
