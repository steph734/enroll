<?php

namespace Database\Seeders;

use App\Models\Tracks;
use App\Models\Strands;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SectionSeeder extends Seeder
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

        // Generate 20 section records
        for ($i = 0; $i < 20; $i++) {
            // Select a random track
            $track = $tracks->random();

            // Select a random strand that belongs to the chosen track
            $availableStrands = $strands->where('track_id', $track->id);
            $strand = $availableStrands->isNotEmpty() ? $availableStrands->random() : $strands->random();

            // Generate a unique section name (e.g., Section A, Section B, etc.)
            $sectionLetter = chr(65 + ($i % 26)); // A, B, C, ..., Z
            $sectionName = "Section {$sectionLetter}-" . $faker->unique()->numberBetween(1, 100);

            Section::create([
                'track_id' => $track->id,
                'strand_id' => $strand->id,
                'section_name' => $sectionName,
                'description' => $faker->boolean(70) ? $faker->sentence(10) : null,
                'school_year' => $faker->randomElement(['2023-2024', '2024-2025', '2025-2026']),
                'GradeLevel' => $faker->randomElement(['Grade 11', 'Grade 12']),
                'status' => $faker->randomElement(['active', 'inactive']),
                'adviser' => $faker->name,
                'room' => $faker->boolean(80) ? 'Room ' . $faker->numberBetween(101, 399) : null,
                'capacity' => $faker->numberBetween(20, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
