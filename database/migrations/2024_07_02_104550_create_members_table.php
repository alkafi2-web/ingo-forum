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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable(false); // Required and unique field
            $table->string('phone')->nullable(); // Phone number
            $table->timestamp('email_verified_at')->nullable(); // Timestamp for email verification
            $table->string('password')->nullable(false); // Required field
            $table->rememberToken()->nullable(); // Token for "remember me" functionality
            $table->string('rp_token')->nullable(); // Reset password token
            $table->timestamp('rp_token_created_at')->nullable(); // Timestamp for reset password token creation
            $table->integer('status')->default(0); // Status of the member
            $table->timestamp('last_login')->nullable(); // Timestamp for the last login
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
