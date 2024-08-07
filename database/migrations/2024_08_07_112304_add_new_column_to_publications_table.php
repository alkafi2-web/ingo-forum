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
        Schema::table('publications', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->after('added_by');
            $table->integer('approval_status')->after('added_by')->nullable();
            $table->integer('approval_status_changed_by')->after('approval_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->after('added_by');
            $table->integer('approval_status')->after('added_by')->nullable();
            $table->integer('approval_status_changed_by')->after('approval_status')->nullable();
        });
    }
};
