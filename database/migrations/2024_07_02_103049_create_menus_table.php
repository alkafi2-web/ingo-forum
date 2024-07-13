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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false); // Required field
            $table->boolean('has_sub_menu')->default(0); // Indicates if the menu has sub-menus
            $table->string('type')->nullable(); // Type of menu item (e.g., page, route, URL, etc.)
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
        Schema::dropIfExists('menus');
    }
};
