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
