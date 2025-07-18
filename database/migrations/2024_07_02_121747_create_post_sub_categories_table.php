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
        Schema::create('post_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id'); // Foreign key referencing postcategories table
            $table->string('name')->nullable(false); // Required field for the subcategory name
            $table->string('slug')->nullable(false); // Required and unique field for the slug
            $table->integer('status')->default(0); // Status of the subcategory

            // Foreign key constraint
            $table->foreign('category_id')->references('id')->on('post_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_sub_categories');
    }
};
