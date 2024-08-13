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
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('bg_image')->nullable();
            $table->json('content_image')->nullable();
            $table->json('background_color')->nullable();
            $table->json('overlay_color')->nullable();
            $table->string('title_color')->nullable();
            $table->string('description_color')->nullable();
            $table->json('button')->nullable();
            $table->integer('position')->nullable();
            $table->unsignedBigInteger('added_by'); // Change existing column type to unsignedBigInteger
            $table->integer('status')->default(0); // Ensure the status column is present and defaulted
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
