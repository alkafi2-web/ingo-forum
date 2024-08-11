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
        Schema::create('file_ngos', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('subcategory_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->longText('attachment')->nullable();
            $table->integer('download_count')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('approval_status')->nullable();
            $table->unsignedBigInteger('approval_status_changed_by')->nullable();
            $table->morphs('creator'); // This creates 'creator_id' and 'creator_type' columns for the polymorphic relation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_ngos');
    }
};
