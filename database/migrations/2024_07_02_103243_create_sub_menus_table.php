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
        Schema::create('sub_menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('menu_id')->unsigned();
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->string('type')->nullable(); // Type of menu item (e.g., route, URL, etc.)
            $table->unsignedBigInteger('page_id')->nullable(); // References the page associated with the menu item
            $table->string('route')->nullable(); // Route name if the type is route
            $table->string('url')->nullable(); // URL if the type is URL
            $table->string('media')->nullable(); // Media associated with the menu item
            $table->longText('content')->nullable(); // Content or description of the menu item
            $table->integer('position')->default(0); // Position for ordering the menu items
            $table->boolean('visibility')->default(1); // Indicates if the menu item is visible
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_menus');
    }
};
