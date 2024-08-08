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
        Schema::table('events', function (Blueprint $table) {
            // Modify existing column
            $table->string('reg_dead_line')->nullable()->change();
            
            // Adding new columns
            $table->tinyInteger('reg_enable_status')->nullable();
            $table->integer('capacity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Reverting changes
            $table->date('reg_dead_line')->nullable()->change();
            $table->dropColumn('reg_enable_status');
            $table->dropColumn('capacity');
        });
    }
};
