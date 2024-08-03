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
        Schema::table('posts', function (Blueprint $table) {
            // Drop the foreign key constraint on added_by
            $table->dropForeign(['added_by']);

            // Drop the index associated with the added_by column if it exists
            $table->dropIndex(['added_by']);

            // Make the added_by column nullable
            $table->unsignedBigInteger('added_by')->nullable()->change();

            // Add the new columns
            $table->unsignedBigInteger('member_id')->nullable()->after('added_by');
            $table->integer('approval_status')->default(0)->after('member_id');
            $table->unsignedBigInteger('approval_status_changed_by')->nullable()->after('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn(['member_id', 'approval_status', 'approval_status_changed_by']);

            // Make the added_by column non-nullable again
            $table->unsignedBigInteger('added_by')->nullable(false)->change();

            // Re-add the index and foreign key constraint on added_by
            $table->index('added_by'); // Re-add the index if it was dropped
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
