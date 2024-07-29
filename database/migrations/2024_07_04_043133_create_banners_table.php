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
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('background_color')->nullable()->default('#D7E8E0');
            $table->string('overlay_color')->nullable()->default('rgba(0, 0, 0, 0.5)');
            $table->string('title_color')->default('#0ca65b');
            $table->string('description_color')->default('#d4d6d8');
            $table->json('button')->nullable(); // JSON field for button details
            $table->integer('status')->default(0); // Status of the banner
            $table->unsignedBigInteger('added_by'); // Foreign key referencing users table
            $table->timestamps();

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
