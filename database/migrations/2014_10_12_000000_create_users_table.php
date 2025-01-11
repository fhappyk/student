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
            $table->string('uuid');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('user_name')->unique()->nullable();
            $table->enum('role', ['student', 'admin'])->default('student');
            $table->enum('status', ['active', 'pending', 'inactive'])->default('pending');
            $table->longText('is_verified')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
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
