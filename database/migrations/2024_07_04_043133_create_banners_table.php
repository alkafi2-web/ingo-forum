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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false); // Required field for the title
            $table->longText('description')->nullable(); // Description of the banner
            $table->string('image')->nullable(); // URL or path to the banner image
            $table->integer('status')->default(0); // Status of the banner
            $table->unsignedBigInteger('added_by'); // Foreign key referencing users table
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraint
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
