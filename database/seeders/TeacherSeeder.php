<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Tracks;
use App\Models\Strands;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Fetch existing Tracks and Strands
        $tracks = Tracks::all();
        $strands = Strands::all();

        // Check if Tracks and Strands exist
        if ($tracks->isEmpty() || $strands->isEmpty()) {
            throw new \Exception('Tracks or Strands are missing in the database. Please ensure they are populated before running the seeder.');
        }

        // Generate 50 teacher records
        for ($i = 0; $i < 50; $i++) {
            // Select a random track
            $track = $tracks->random();

            // Select a random strand that belongs to the chosen track
            $availableStrands = $strands->where('track_id', $track->id);
            $strand = $availableStrands->isNotEmpty() ? $availableStrands->random() : $strands->random();

            Teacher::create([
                'profile_picture' => $faker->boolean(50) ? 'storage/profiles/teacher_' . $faker->uuid . '.jpg' : null,
                'first_name' => $faker->firstName,
                'middle_name' => $faker->boolean(50) ? $faker->firstName : null,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-25 years')->format('Y-m-d'),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'age' => $faker->numberBetween(25, 60),
                'nationality' => $faker->country,
                'address' => $faker->address,
                'contact_number' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'degree' => $faker->randomElement(['Bachelor of Education', 'Master of Arts', 'Doctor of Philosophy']),
                'major' => $faker->randomElement(['Mathematics', 'Science', 'English', 'History', 'Physical Education']),
                'university' => $faker->company . ' University',
                'year_graduated' => $faker->numberBetween(1980, 2023),
                'prc_license' => 'PRC' . $faker->unique()->numberBetween(100000, 999999),
                'license_validity' => $faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
                'let_date' => $faker->dateTimeBetween('-20 years', 'now')->format('Y-m-d'),
                'specialization' => $faker->randomElement(['Academic', 'TVL', 'Sports', 'Arts']),
                'prc_copy' => 'storage/documents/prc_' . $faker->uuid . '.pdf',
                'previous_school' => $faker->boolean(50) ? $faker->company . ' High School' : null,
                'position' => $faker->boolean(50) ? $faker->randomElement(['Professor', 'Associate Professor', 'Assistant Professor', 'Lecturer']) : null,
                'years_experience' => $faker->numberBetween(0, 35),
                'employment_status' => $faker->randomElement(['Full-time', 'Part-time']),
                'teaching_schedule' => $faker->randomElement(['Morning', 'Afternoon', 'Evening']),
                'subjects' => $faker->randomElement(['Mathematics', 'Science', 'English', 'History', 'Physical Education', 'Visual Arts']),
                'certifications' => $faker->boolean(40) ? $faker->sentence(5) : null,
                'medical_info' => $faker->boolean(30) ? $faker->sentence(10) : null,
                'accommodations' => $faker->boolean(20) ? $faker->sentence(8) : null,
              'resume' => 'storage/documents/resume_' . $faker->uuid . '.pdf',
                 'transcript' => 'storage/documents/transcript_' . $faker->uuid . '.pdf',
                'date_hired' => $faker->dateTimeBetween('-20 years', 'now')->format('Y-m-d'),
                'employee_id' => $faker->unique()->numberBetween(100000, 999999),
                'status' => $faker->randomElement(['Active', 'Inactive', 'On Leave']),
                
            ]);
        }
    }
}