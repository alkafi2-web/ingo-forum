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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false); // Required field for the title of the event
            $table->longText('details')->nullable(); // Details or description of the event
            $table->string('media')->nullable(); // Media or image related to the event
            $table->date('start_date')->nullable(); // Start date of the event
            $table->date('end_date')->nullable(); // End date of the event
            $table->string('location')->nullable(); // Location or venue of the event
            $table->string('type')->nullable(); // Type of event (e.g., conference, workshop)
            $table->date('reg_dead_line')->nullable(); // Registration deadline for the event
            $table->string('ref_fees')->nullable(); // Registration fees or fees related to the event
            $table->string('status')->default(0); // Status of the event, default to active
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
