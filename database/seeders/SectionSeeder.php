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
            'sectioname' => 'STEM-A1',
            'gradelevel' => 'Grade 11',
            'code' => 'STEM-A1-102',
        ]);

        Section::create([
            'sectioname' => 'STEM-A2',
            'gradelevel' => 'Grade 12',
            'code' => 'STEM-A2-101',
        ]);

        Section::create([
            'sectioname' => 'STEM-A2',
            'gradelevel' => 'Grade 12',
            'code' => 'STEM-A2-102',
        ]);

        Section::create([
            'sectioname' => 'ABM-B1',
            'gradelevel' => 'Grade 11',
            'code' => 'ABM-B1-101',
        ]);

        Section::create([
            'sectioname' => 'ABM-B1',
            'gradelevel' => 'Grade 11',
            'code' => 'ABM-B1-102',
        ]);

        Section::create([
            'sectioname' => 'ABM-B2',
            'gradelevel' => 'Grade 12',
            'code' => 'ABM-B2-101',
        ]);

        Section::create([
            'sectioname' => 'ABM-B2',
            'gradelevel' => 'Grade 12',
            'code' => 'ABM-B2-102',
        ]);

        Section::create([
            'sectioname' => 'HUMSS-C1',
            'gradelevel' => 'Grade 11',
            'code' => 'HUMSS-C1-101',
        ]);

        Section::create([
            'sectioname' => 'HUMSS-C2',
            'gradelevel' => 'Grade 12',
            'code' => 'HUMSS-C2-101',
        ]);

        Section::create([
            'sectioname' => 'GAS-D1',
            'gradelevel' => 'Grade 11',
            'code' => 'GAS-D1-101',
        ]);

        Section::create([
            'sectioname' => 'GAS-D2',
            'gradelevel' => 'Grade 12',
            'code' => 'GAS-D2-101',
        ]);

        Section::create([
            'sectioname' => 'TVL-ICT-1',
            'gradelevel' => 'Grade 11',
            'code' => 'TVL-ICT1-101',
        ]);

        Section::create([
            'sectioname' => 'TVL-ICT-2',
            'gradelevel' => 'Grade 12',
            'code' => 'TVL-ICT2-101',
        ]);

        Section::create([
            'sectioname' => 'TVL-HE-1',
            'gradelevel' => 'Grade 11',
            'code' => 'TVL-HE1-101',
        ]);

        Section::create([
            'sectioname' => 'TVL-HE-2',
            'gradelevel' => 'Grade 12',
            'code' => 'TVL-HE2S-101',
        ]);

       
    }
}
