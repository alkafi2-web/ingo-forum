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
            $table->integer('album_id')->nullable(); // Required field for the type of media
            $table->string('name')->nullable(); // Required field for the name of the media
            $table->string('media')->nullable(); // Main media
            $table->string('mob_media')->nullable(); // Mobile media
            $table->string('sub_media')->nullable(); // Sub media
            $table->longText('content')->nullable(); // Main content
            $table->longText('sub_content')->nullable(); // Sub content
            $table->integer('position')->default(0); // Position for ordering the media items
            $table->string('url')->nullable(); // URL associated with the media
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('added_by'); // Status of the album, default to active
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
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
