<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER after_student_insert_stem
            AFTER INSERT ON students
            FOR EACH ROW
            BEGIN
                DECLARE stem_a1_id INT;
                DECLARE stem_a2_id INT;

                -- Only proceed if student strand is STEM
                IF NEW.strand = "STEM" THEN
                    -- Find STEM-A1 section
                    SELECT id INTO stem_a1_id
                    FROM section
                    WHERE sectioname = "STEM-A1" AND current_slots > 0
                    LIMIT 1;

                    -- If STEM-A1 has slots, enroll and deduct slot
                    IF stem_a1_id IS NOT NULL THEN
                        INSERT INTO section_student (student_id, section_id, created_at, updated_at)
                        VALUES (NEW.id, stem_a1_id, NOW(), NOW());

                        UPDATE section
                        SET current_slots = current_slots - 1
                        WHERE id = stem_a1_id;
                    ELSE
                        -- Find STEM-A2 section
                        SELECT id INTO stem_a2_id
                        FROM section
                        WHERE sectioname = "STEM-A2" AND current_slots > 0
                        LIMIT 1;

                        -- If STEM-A2 has slots, enroll and deduct slot
                        IF stem_a2_id IS NOT NULL THEN
                            INSERT INTO section_student (student_id, section_id, created_at, updated_at)
                            VALUES (NEW.id, stem_a2_id, NOW(), NOW());

                            UPDATE sections
                            SET current_slots = current_slots - 1
                            WHERE id = stem_a2_id;
                        END IF;
                    END IF;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_student_insert');
    }
};
