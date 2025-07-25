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
        Schema::table('member_infos', function (Blueprint $table) {
            $table->text('organisation_ngo_reg')->nullable()->after('organisation_website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_infos', function (Blueprint $table) {
            $table->dropColumn('organisation_ngo_reg');
        });
    }
};
