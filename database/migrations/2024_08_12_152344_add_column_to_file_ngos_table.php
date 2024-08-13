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
        Schema::table('file_ngos', function (Blueprint $table) {
            $table->json('assign_to')->nullable()->after('creator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_ngos', function (Blueprint $table) {
            $table->dropColumn('assign_to');
        });
    }
};
