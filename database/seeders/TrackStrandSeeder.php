<?php

namespace Database\Seeders;

use App\Models\Tracks;
use App\Models\Strands;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackStrandSeeder extends Seeder
{
    public function run()
    {
        try {
            // Begin a transaction for data consistency
            DB::beginTransaction();

            // Define tracks and their strands
            $tracks = [
                [
                    'track_name' => 'Academic',
                    'description' => 'Prepares students for college education with degree-specific courses.',
                    'strands' => [
                        ['strand_name' => 'Accountancy, Business, and Management (ABM)', 'description' => 'Focuses on business, finance, and management concepts.'],
                        ['strand_name' => 'Science, Technology, Engineering, and Mathematics (STEM)', 'description' => 'Emphasizes advanced science, math, and engineering topics.'],
                        ['strand_name' => 'Humanities and Social Sciences (HUMSS)', 'description' => 'Covers culture, politics, arts, and social sciences.'],
                        ['strand_name' => 'General Academic Strand (GAS)', 'description' => 'Offers flexible subjects for students undecided on specialization.'],
                    ],
                ],
                [
                    'track_name' => 'Technical-Vocational-Livelihood (TVL)',
                    'description' => 'Equips students with job-ready skills and TESDA certifications.',
                    'strands' => [
                        ['strand_name' => 'Agri-Fishery Arts', 'description' => 'Focuses on agriculture and fishery techniques.'],
                        ['strand_name' => 'Home Economics (HE)', 'description' => 'Covers skills like cookery, caregiving, and tourism.'],
                        ['strand_name' => 'Information and Communications Technology (ICT)', 'description' => 'Includes programming, animation, and IT skills.'],
                        ['strand_name' => 'Industrial Arts', 'description' => 'Emphasizes technical skills like welding and automotive servicing.'],
                    ],
                ],
                [
                    'track_name' => 'Sports',
                    'description' => 'Prepares students for careers in athletics, coaching, and fitness.',
                    'strands' => [
                        ['strand_name' => 'Sports', 'description' => 'Focuses on sports science, coaching, and athletic development.'],
                    ],
                ],
                [
                    'track_name' => 'Arts and Design',
                    'description' => 'Develops skills in visual and performing arts.',
                    'strands' => [
                        ['strand_name' => 'Arts and Design', 'description' => 'Covers theater, music, dance, and visual arts.'],
                    ],
                ],
            ];

            // Insert tracks and strands
            foreach ($tracks as $trackData) {
                // Get or create the Track
                $track = Tracks::firstOrCreate(
                    ['track_name' => $trackData['track_name']],
                    ['description' => $trackData['description']]
                );

                // Insert strands for this track
                foreach ($trackData['strands'] as $strandData) {
                    $track->strands()->firstOrCreate(
                        ['strand_name' => $strandData['strand_name']],
                        ['description' => $strandData['description']]
                    );
                }
            }

            // Commit the transaction
            DB::commit();
            echo "Tracks and strands seeded successfully.";
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
