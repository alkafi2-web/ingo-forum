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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id'); // Foreign key referencing events table
            $table->unsignedBigInteger('member_id'); // Foreign key referencing members table (or users table)
            $table->string('representive_name')->nullable(); // Representative's name
            $table->string('representive_email')->nullable(); // Representative's email
            $table->string('representive_phone')->nullable(); // Representative's phone number
            $table->longText('guest_info')->nullable(); // Information about guests
            $table->integer('total_participant')->default(1); // Total number of participants
            $table->integer('reg_fees_status')->nullable(0); // Registration fees status
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraints
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            // Assuming 'members' table for member_id, adjust as per your actual table name
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
