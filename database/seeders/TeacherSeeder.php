<?php

namespace Database\Seeders;

use App\Models\Teacher; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        Teacher::create([
            'first_name' => 'John',
            'middle_name' => 'A',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'age' => 35,
        ]);
        Teacher::create([
            'first_name' => 'Jane',
            'middle_name' => 'B',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'age' => 42,
        ]);
    }
}
