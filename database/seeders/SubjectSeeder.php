<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Tracks;
use App\Models\Strands;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SubjectSeeder extends Seeder
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
        if ($tracks->isEmpty()) {
            throw new \Exception('No Tracks found in the database. Please seed the Tracks table first.');
        }
        if ($strands->isEmpty()) {
            throw new \Exception('No Strands found in the database. Please seed the Strands table first.');
        }

        // Generate 30 subject records
        for ($i = 0; $i < 30; $i++) {
            // Select a random track
            $track = $tracks->random();

            // Select a random strand that belongs to the chosen track
            $availableStrands = $strands->where('track_id', $track->id);

            // If no strands are available for this track, skip or assign a random strand
            if ($availableStrands->isEmpty()) {
                // Option 1: Skip this subject creation (uncomment to use)
                // continue;

                // Option 2: Use a random strand as fallback
                $strand = $strands->random();
            } else {
                $strand = $availableStrands->random();
            }

            Subject::create([
                'subject_name' => $faker->randomElement([
                    'Mathematics', 'Physics', 'Chemistry', 'Biology', 'Literature',
                    'History', 'Computer Science', 'Economics', 'Psychology', 'Sociology',
                    'Art', 'Music Theory', 'Physical Education', 'Statistics', 'Philosophy'
                ]) . ' ' . $faker->randomElement(['I', 'II', 'III', 'Advanced', 'Introductory']),
                'description' => $faker->sentence(10, true),
            ]);
        }
    }
}