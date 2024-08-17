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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // e.g., button, text field, image, etc.
            $table->json('html')->nullable(); // Store the HTML code for the widget
            $table->json('css')->nullable(); // Store the CSS code for the widget
            $table->json('settings')->nullable(); //store the settings like columns, other styles or layouts or other structure
            $table->integer('applicable_on')->default(1)->nullable(); //1 means frontend and 2 means backend or admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
