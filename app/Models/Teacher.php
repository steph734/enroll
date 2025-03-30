<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'profile_picture', 'first_name', 'middle_name', 'last_name', 'date_of_birth',
        'gender', 'age', 'nationality', 'address', 'contact_number', 'email',
        'degree', 'major', 'university', 'year_graduated', 'prc_license',
        'license_validity', 'let_date', 'specialization', 'prc_copy',
        'previous_school', 'position', 'years_experience', 'employment_status',
        'teaching_schedule', 'subjects', 'certifications', 'medical_info',
        'accommodations', 'resume', 'transcript', 'date_hired', 'employee_id'
    ];
}

