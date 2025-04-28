<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'subjectname' => 'Mathematics',
                'description' => 'Fundamentals of algebra and geometry',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'English Literature',
                'description' => 'Study of classic and modern literature',
                'start_time' => '09:45:00',
                'end_time' => '11:15:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'Biology',
                'description' => 'Introduction to cell biology and ecosystems',
                'start_time' => '11:30:00',
                'end_time' => '13:00:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'History',
                'description' => 'World history from ancient civilizations to modern times',
                'start_time' => '13:15:00',
                'end_time' => '14:45:00',
                'gradelevel' => 'Grade 12',
            ],
            [
                'subjectname' => 'Physics',
                'description' => 'Mechanics and basic principles of physics',
                'start_time' => '15:00:00',
                'end_time' => '16:30:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'Computer Science',
                'description' => 'Basics of programming and algorithms',
                'start_time' => '08:30:00',
                'end_time' => '10:00:00',
                'gradelevel' => 'Grade 12',
            ],
            [
                'subjectname' => 'Chemistry',
                'description' => 'Atomic structure and chemical reactions',
                'start_time' => '10:15:00',
                'end_time' => '11:45:00',
                'gradelevel' => 'Grade 12',
            ],
            // TVL-ICT Subjects
            [
                'subjectname' => 'Computer Programming',
                'description' => 'Introduction to coding languages like Python and Java',
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'Network Administration',
                'description' => 'Fundamentals of computer networks and system maintenance',
                'start_time' => '09:45:00',
                'end_time' => '11:15:00',
                'gradelevel' => 'Grade 12',
            ],
            // TVL-HE Subjects
            [
                'subjectname' => 'Food and Beverage Services',
                'description' => 'Skills in food preparation and customer service',
                'start_time' => '11:30:00',
                'end_time' => '13:00:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'Housekeeping',
                'description' => 'Techniques in maintaining clean and safe environments',
                'start_time' => '13:15:00',
                'end_time' => '14:45:00',
                'gradelevel' => 'Grade 12',
            ],
            // HUMSS Subjects
            [
                'subjectname' => 'Introduction to World Religions',
                'description' => 'Study of major world religions and belief systems',
                'start_time' => '15:00:00',
                'end_time' => '16:30:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'Creative Writing',
                'description' => 'Developing skills in narrative and poetic writing',
                'start_time' => '08:30:00',
                'end_time' => '10:00:00',
                'gradelevel' => 'Grade 12',
            ],
            // GAS Subjects
            [
                'subjectname' => 'General Mathematics',
                'description' => 'Basic concepts in statistics and business math',
                'start_time' => '10:15:00',
                'end_time' => '11:45:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'Social Science',
                'description' => 'Introduction to sociology and anthropology',
                'start_time' => '11:30:00',
                'end_time' => '13:00:00',
                'gradelevel' => 'Grade 12',
            ],
            // ABM Subjects
            [
                'subjectname' => 'Fundamentals of Accountancy',
                'description' => 'Basic principles of accounting and bookkeeping',
                'start_time' => '13:15:00',
                'end_time' => '14:45:00',
                'gradelevel' => 'Grade 11',
            ],
            [
                'subjectname' => 'Business Ethics and Social Responsibility',
                'description' => 'Ethical practices in business and corporate responsibility',
                'start_time' => '15:00:00',
                'end_time' => '16:30:00',
                'gradelevel' => 'Grade 12',
            ],
        ];
            // More subjects...
      
        
        foreach ($subjects as $subject) {
            Subject::create(array_merge($subject, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
