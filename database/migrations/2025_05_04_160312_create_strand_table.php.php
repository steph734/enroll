<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('strand', function (Blueprint $table) {
            // Add track_id column if it doesn't exist
            if (!Schema::hasColumn('strand', 'track_id')) {
                $table->unsignedBigInteger('track_id')->after('description')->nullable();
                $table->foreign('track_id')
                    ->references('id')
                    ->on('tracks')
                    ->onDelete('cascade');
            }

            // Migrate data from 'track' to 'track_id' if 'track' column exists
            if (Schema::hasColumn('strand', 'track')) {
                try {
                    // Insert missing tracks from strand.track
                    DB::statement("
                        INSERT INTO tracks (trackname, description, created_at, updated_at)
                        SELECT DISTINCT track, 'Auto-generated track', NOW(), NOW()
                        FROM strand
                        WHERE track IS NOT NULL
                        AND track NOT IN (SELECT trackname FROM tracks)
                    ");

                    // Update strand.track_id
                    DB::statement('
                        UPDATE strand s
                        INNER JOIN tracks t ON s.track = t.trackname
                        SET s.track_id = t.id
                        WHERE s.track IS NOT NULL
                    ');
                } catch (\Exception $e) {
                    Log::error('Failed to migrate strand.track to track_id: ' . $e->getMessage());
                }

                // Drop track column
                $table->dropColumn('track');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('strand', function (Blueprint $table) {
            // Restore 'track' column
            if (!Schema::hasColumn('strand', 'track')) {
                $table->string('track')->after('description')->nullable();
            }

            // Drop foreign key and track_id column
            if (Schema::hasColumn('strand', 'track_id')) {
                $table->dropForeign(['track_id']);
                $table->dropColumn('track_id');
            }
        });
    }
};
