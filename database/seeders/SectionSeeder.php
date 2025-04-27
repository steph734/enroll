<?php

namespace Database\Seeders;


use App\Models\Section;
use App\Models\Strand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'sectioname' => 'STEM-A1',
            'gradelevel' => 'Grade 11',
            'code' => 'STEM-A1-101',
        ]);

        Section::create([
            'sectioname' => 'STEM-A2',
            'gradelevel' => 'Grade 12',
            'code' => 'STEM-A1-102',
        ]);

        Section::create([
            'sectioname' => 'ABM-B2',
            'gradelevel' => 'Grade 12',
            'code' => 'ABM-B1-101',
        ]);

        Section::create([
            'sectioname' => 'STEM-C3',
            'gradelevel' => 'Grade 11',
            'code' => 'HUMSS-C1-101',
        ]);
    }
}
