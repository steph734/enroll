<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(TrackStrandSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(SubjectSeeder::class);
    }
}
