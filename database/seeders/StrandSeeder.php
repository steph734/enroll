<?php

namespace Database\Seeders;

use App\Models\Strand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strands = [
            [
                'strandname' => 'STEM',
                'description' => 'Science, Technology, Engineering, and Mathematics strand for technical fields.',
                'track' => 'Academic',
            ],
            [
                'strandname' => 'ABM',
                'description' => 'Accountancy, Business, and Management strand for business-related careers.',
                'track' => 'Academic',
            ],
            [
                'strandname' => 'HUMSS',
                'description' => 'Humanities and Social Sciences strand for social studies and humanities.',
                'track' => 'Academic',
            ],

            [
                'strandname' => 'GAS',
                'description' => 'General Academic Strand for a flexible curriculum combining various academic disciplines.',
                'track' => 'Academic',
            ],
            
            [
                'strandname' => 'TVL-ICT',
                'description' => 'Technical-Vocational-Livelihood track specializing in Information and Communications Technology.',
                'track' => 'Vocational',
            ],
            [
                'strandname' => 'TVL-HE',
                'description' => 'Technical-Vocational-Livelihood track specializing in Home Economics.',
                'track' => 'Vocational',
            ],
        ];

        foreach ($strands as $strand) {
            Strand::create(array_merge($strand, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    
    }
}
