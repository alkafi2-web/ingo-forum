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
        Schema::table('media_galleries', function (Blueprint $table) {
            $table->renameColumn('mewdia', 'media'); // Renaming an existing column
            $table->unsignedBigInteger('album_id')->after('name');

            // Assuming `related_table` is the name of the related table
            // and `id` is the column in `related_table` being referenced
            $table->foreign('album_id')
                ->references('id')
                ->on('media_albums')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_galleries', function (Blueprint $table) {
            // Dropping the foreign key and the column
            $table->dropForeign(['album_id']);
            $table->dropColumn('album_id');

            // Reverting the column name change
            $table->renameColumn('mewdia', 'media');
        });
    }
};
