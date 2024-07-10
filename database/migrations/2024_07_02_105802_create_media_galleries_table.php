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
        Schema::create('media_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // Required field for the type of media
            $table->string('name')->nullable(); // Required field for the name of the media
            $table->string('mewdia')->nullable(); // Main media
            $table->string('mob_media')->nullable(); // Mobile media
            $table->string('sub_media')->nullable(); // Sub media
            $table->longText('content')->nullable(); // Main content
            $table->longText('sub_content')->nullable(); // Sub content
            $table->integer('position')->default(0); // Position for ordering the media items
            $table->string('url')->nullable(); // URL associated with the media
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_galleries');
    }
};
