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
        Schema::create('member_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id'); // Foreign key referencing members table
            $table->string('name')->nullable(); // Required field
            $table->string('membership_id')->nullable(); // Membership ID
            $table->string('rep_name')->nullable(); // Representative name
            $table->string('rep_designation')->nullable(); // Representative designation
            $table->string('rep_email')->nullable(); // Representative email
            $table->string('rep_phone')->nullable(); // Representative phone
            $table->string('rep_photo')->nullable(); // Representative photo
            $table->string('rep_social')->nullable(); // Representative social media handle
            $table->string('member_type')->nullable(); // Type of member
            $table->date('establish_date')->nullable(); // Establishment date
            $table->longText('address')->nullable(); // Address
            $table->longText('head_content')->nullable(); // Main content or description
            $table->longText('mission')->nullable(); // Mission statement
            $table->longText('vision')->nullable(); // Vision statement
            $table->longText('value')->nullable(); // Values of the organization
            $table->text('work')->nullable(); // Work or projects
            $table->longText('history')->nullable(); // History of the organization
            $table->text('services')->nullable(); // Services offered
            $table->string('website')->nullable(); // Website URL
            $table->string('facebook')->nullable(); // Facebook URL
            $table->string('linkedin')->nullable(); // LinkedIn URL
            $table->string('youtube')->nullable(); // YouTube URL
            $table->string('google_map')->nullable(); // Google Map URL
            $table->string('logo')->nullable(); // Logo
            $table->string('profile_attachment')->nullable(); // Profile attachment
            $table->string('attachment1')->nullable(); // Additional attachment
            $table->string('attachment2')->nullable(); // Additional attachment
            $table->string('attachment3')->nullable(); // Additional attachment
            $table->json('json_content')->nullable(); // JSON content
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraint
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_infos');
    }
};
