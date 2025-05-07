<?php

namespace Database\Seeders;

use App\Models\Strand; 
use App\Models\Tracks;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrandSeeder extends Seeder
{
   public function run(): void
    {
        $stem = Tracks::firstOrCreate(
            ['trackname' => 'STEM'],
            ['description' => 'Science, Technology, Engineering, and Mathematics']
        );
        $humss = Tracks::firstOrCreate(
            ['trackname' => 'HUMSS'],
            ['description' => 'Humanities and Social Sciences']
        );
        $abm = Tracks::firstOrCreate(
            ['trackname' => 'ABM'],
            ['description' => 'Accountancy, Business, and Management']
        );

        $science = Strand::create([
            'name' => 'Science Strand',
            'description' => 'Science-focused strand',
        ]);
        $science->tracks()->attach([$stem->id, $abm->id]);

        $humanities = Strand::create([
            'name' => 'Humanities Strand',
            'description' => 'Humanities-focused strand',
        ]);
        $humanities->tracks()->attach([$humss->id, $stem->id]);

        $business = Strand::create([
            'name' => 'Business Strand',
            'description' => 'Business-focused strand',
        ]);
        $business->tracks()->attach([$abm->id, $stem->id]);
    }
}


