<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

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
        'zip_code',
        'guardian_first_name',
        'guardian_last_name',
        'relationship',
        'guardian_contact',
        'previous_school',
        'grade_completed',
        'school_year_completed',
        'transcript',
        'track',
        'strand',
        'class_schedule',
        'payment_amount',
        'payment_date',
        'receipt_number',
        'payment_method',
        'home_address',
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