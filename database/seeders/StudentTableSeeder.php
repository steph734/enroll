<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Tracks;
use App\Models\Strands;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Fetch existing Tracks, Strands, and Sections
        $tracks = Tracks::all();
        $strands = Strands::all();
        $sections = Section::all();

        // Check if Tracks, Strands, and Sections exist
        if ($tracks->isEmpty() || $strands->isEmpty() || $sections->isEmpty()) {
            throw new \Exception('Tracks, Strands, or Sections are missing in the database. Please ensure they are populated before running the seeder.');
        }

        // Generate 50 student records
        for ($i = 0; $i < 200; $i++) {
            // Select a random track
            $track = $tracks->random();

            // Select a random strand that belongs to the chosen track
            $availableStrands = $strands->where('track_id', $track->id);
            $strand = $availableStrands->isNotEmpty() ? $availableStrands->random() : $strands->random();

            // Select a random section that belongs to the chosen strand
            $availableSections = $sections->where('strand_id', $strand->id);
            $section = $availableSections->isNotEmpty() ? $availableSections->random() : $sections->random();

            Student::create([
                'profile_picture' => 'storage/profiles/sample_' . $faker->uuid . '.jpg',
                'first_name' => $faker->firstName,
                'middle_name' => $faker->boolean(50) ? $faker->firstName : null,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->dateTimeBetween('-20 years', '-15 years')->format('Y-m-d'),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'age' => $faker->numberBetween(15, 20),
                'nationality' => $faker->country,
                'home_address' => $faker->address,
                'zip_code' => $faker->postcode,
                'contact_number' => $faker->phoneNumber,
                'secondary_contact' => $faker->boolean(30) ? $faker->phoneNumber : null,
                'email' => $faker->unique()->safeEmail,
                'guardian_first_name' => $faker->firstName,
                'guardian_middle_name' => $faker->boolean(50) ? $faker->firstName : null,
                'guardian_last_name' => $faker->lastName,
                'relationship' => $faker->randomElement(['Mother', 'Father', 'Guardian', 'Other']),
                'guardian_contact' => $faker->phoneNumber,
                'guardian_email' => $faker->boolean(70) ? $faker->safeEmail : null,
                'previous_school' => $faker->company . ' High School',
                'grade_completed' => $faker->randomElement(['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10']),
                'school_year_completed' => $faker->randomElement(['2020-2021', '2021-2022', '2022-2023', '2023-2024']),
                'gpa' => $faker->boolean(60) ? $faker->numberBetween(75, 100) : null,
                'transcript' => 'storage/transcripts/transcript_' . $faker->uuid . '.pdf',
                'track_id' => $track->id,
                'strand_id' => $strand->id,
                'section_id' => $section->id,
                'grade_level' => $faker->randomElement(['Grade 11', 'Grade 12']),
                'class_schedule' => $faker->randomElement(['Morning', 'Afternoon', 'Evening']),
                'additional_notes' => $faker->boolean(40) ? $faker->sentence : null,
                'medical_info' => $faker->boolean(30) ? $faker->sentence(10, true) : null,
                'special_accommodations' => $faker->boolean(20) ? $faker->sentence(8, true) : null,
                'studentid' => $faker->unique()->numberBetween(100000, 999999),
                'payment_date' => $faker->dateTimeThisYear()->format('Y-m-d'),
                'downpayment' => $faker->randomFloat(2, 500, 5000),
                'payment_method' => $faker->randomElement(['Cash', 'Credit Card', 'Bank Transfer', 'Online Payment']),
                'balance' => $faker->randomFloat(2, 10000, 30000),
                'receiptnumber' => $faker->unique()->numberBetween(100000, 999999),
            ]);
        }
    }
}
