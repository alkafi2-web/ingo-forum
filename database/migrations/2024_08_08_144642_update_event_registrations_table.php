<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\EventRegistration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            // Rename columns
            $table->renameColumn('representive_name', 'attendee_name');
            $table->renameColumn('representive_email', 'attendee_email');
            $table->renameColumn('representive_phone', 'attendee_phone');

            // Add new column
            $table->string('reg_fees')->nullable()->after('total_participant');

            // Update existing column with default value
            $table->integer('reg_fees_status')->default(1)->change();

            // Drop foreign key constraint
            $table->dropForeign(['member_id']);

            // Make member_id nullable
            $table->unsignedBigInteger('member_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            // Revert the renaming of columns
            $table->renameColumn('attendee_name', 'representive_name');
            $table->renameColumn('attendee_email', 'representive_email');
            $table->renameColumn('attendee_phone', 'representive_phone');

            // Drop the new column
            $table->dropColumn('reg_fees');

            // Revert the existing column's default value change
            $table->integer('reg_fees_status')->default(0)->change();

            // Revert the member_id column back to non-nullable
            $table->unsignedBigInteger('member_id')->nullable(false)->change();

            // Re-add the foreign key constraint
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }
};
