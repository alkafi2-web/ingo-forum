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
            $table->string('organisation_phone')->nullable()->after('organisation_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_infos', function (Blueprint $table) {
            $table->dropColumn('organisation_phone');
        });
    }
};
