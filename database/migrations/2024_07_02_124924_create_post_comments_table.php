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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id'); // Foreign key referencing posts table
            $table->longText('comment')->nullable(); // Content of the comment
            $table->unsignedBigInteger('member_id'); // Foreign key referencing members table (or users table)
            $table->integer('status')->default(0); // Status of the comment
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraints
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            // Assuming 'members' table for member_id, adjust as per your actual table name
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
