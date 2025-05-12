<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['subject_code' => 'MATH101', 'subject_name' => 'Basic Mathematics', 'description' => 'Introduction to basic math concepts.', 'strand_id' => 1, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'ENG102', 'subject_name' => 'English Literature', 'description' => 'Study of English literature.', 'strand_id' => 2, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '4th Term'],
            ['subject_code' => 'SCI103', 'subject_name' => 'General Science', 'description' => 'Overview of scientific principles.', 'strand_id' => 3, 'track_id' => 2, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '2nd Term'],
            ['subject_code' => 'HIST104', 'subject_name' => 'World History', 'description' => 'Comprehensive study of world history.', 'strand_id' => 4, 'track_id' => 3, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'PHYS105', 'subject_name' => 'Physics', 'description' => 'Study of physical laws and principles.', 'strand_id' => 1, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '4th Term'],
            ['subject_code' => 'CHEM106', 'subject_name' => 'Chemistry', 'description' => 'Introduction to chemical reactions.', 'strand_id' => 1, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '2nd Term'],
            ['subject_code' => 'BIO107', 'subject_name' => 'Biology', 'description' => 'Study of living organisms.', 'strand_id' => 3, 'track_id' => 2, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'ECON108', 'subject_name' => 'Economics', 'description' => 'Principles of economics.', 'strand_id' => 2, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'COMP109', 'subject_name' => 'Computer Science', 'description' => 'Introduction to programming.', 'strand_id' => 3, 'track_id' => 2, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '4th Term'],
            ['subject_code' => 'ART110', 'subject_name' => 'Art Appreciation', 'description' => 'Understanding and appreciating art.', 'strand_id' => 4, 'track_id' => 3, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '3rd Term'],
            ['subject_code' => 'PE111', 'subject_name' => 'Physical Education', 'description' => 'Physical fitness and sports.', 'strand_id' => 4, 'track_id' => 3, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'MUSIC112', 'subject_name' => 'Music Theory', 'description' => 'Study of music fundamentals.', 'strand_id' => 4, 'track_id' => 3, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '4th Term'],
            ['subject_code' => 'PHIL113', 'subject_name' => 'Philosophy', 'description' => 'Introduction to philosophical thought.', 'strand_id' => 2, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '2nd Term'],
            ['subject_code' => 'PSY114', 'subject_name' => 'Psychology', 'description' => 'Study of human behavior.', 'strand_id' => 3, 'track_id' => 2, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'SOC115', 'subject_name' => 'Sociology', 'description' => 'Study of society and social behavior.', 'strand_id' => 2, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'STAT116', 'subject_name' => 'Statistics', 'description' => 'Introduction to statistical methods.', 'strand_id' => 1, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '3rd Term'],
            ['subject_code' => 'GEO117', 'subject_name' => 'Geography', 'description' => 'Study of Earth and its features.', 'strand_id' => 4, 'track_id' => 3, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'LIT118', 'subject_name' => 'World Literature', 'description' => 'Study of global literary works.', 'strand_id' => 2, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '1st Term'],
            ['subject_code' => 'ENV119', 'subject_name' => 'Environmental Science', 'description' => 'Study of environmental issues.', 'strand_id' => 3, 'track_id' => 2, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '2nd Term'],
            ['subject_code' => 'BUS120', 'subject_name' => 'Business Management', 'description' => 'Principles of business management.', 'strand_id' => 2, 'track_id' => 1, 'grade_level' => 'Grade 11', 'semester' => '1st Sem', 'term' => '4th Term'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
