<?php

namespace Database\Seeders;


use App\Models\Tracks; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Tracks::create(['trackname' => 'Academic', 'description' => 'Focuses on Science, Technology, Engineering, and Mathematics (STEM)']);
        Tracks::create(['trackname' => 'Technical-Vocational-Livelihood (TVL)', 'description' => 'Provides practical, hands-on training in technical and vocational skills']);
        Tracks::create(['trackname' => ' Arts and Design', 'description' => 'Centers on creative disciplines such as visual arts, performing arts, and design']);
        Tracks::create(['trackname' => '  Sports', 'description' => 'Develops skills in sports science, coaching, and athletic management']);
    
        }
    }

