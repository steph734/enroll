<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'profile_picture',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'age',
        'nationality',
        'address',
        'contact_number',
        'email',
        'school',
        'grade_level',
        'year_graduated',
        'parent_name',
        'parent_contact',
        'parent_email',
    ];
}