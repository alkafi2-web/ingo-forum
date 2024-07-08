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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id'); // Foreign key referencing post_categories table
            $table->unsignedBigInteger('sub_category_id')->nullable(); // Foreign key referencing post_subcategories table
            $table->string('title')->nullable(false); // Required field for the title of the post
            $table->string('slug')->nullable(false); // Required field for the title of the post
            $table->text('short_des')->nullable(); // Short description of the post
            $table->text('long_des')->nullable(); // Long description or content of the post
            $table->string('banner')->nullable(); // Banner or featured image URL
            $table->integer('status')->default(0); // Status of the post
            $table->unsignedBigInteger('added_by'); // Foreign key referencing users table (added by)
            $table->json('seo')->nullable(); // JSON field for SEO metadata
            $table->json('og')->nullable(); // JSON field for Open Graph metadata
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('post_categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('post_sub_categories')->onDelete('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
