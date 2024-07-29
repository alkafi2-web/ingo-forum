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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('publisher')->nullable();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->text('short_description')->nullable();
            $table->date('publish_date')->nullable();
            $table->string('file')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default(0);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('category_id')->references('id')->on('publication_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
