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
        Schema::create('media_albums', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false); // Required field for the title
            $table->text('content')->nullable(); // Main content of the album
            $table->text('subcontent')->nullable(); // Sub-content of the album
            $table->string('albumtype')->nullable(); // Type of the album
            $table->integer('status')->default(0); // Status of the album, default to active
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_albums');
    }
};
