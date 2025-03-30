<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_picture', 'first_name', 'middle_name', 'last_name',
        'date_of_birth', 'gender', 'age', 'nationality', 'home_address',
        'zip_code', 'contact_number', 'secondary_contact', 'email',
        'guardian_first_name', 'guardian_middle_name', 'guardian_last_name',
        'relationship', 'guardian_contact', 'guardian_email',
        'previous_school', 'grade_completed', 'school_year_completed',
        'gpa', 'transcript', 'track', 'strand', 'grade_level',
        'class_schedule', 'additional_notes', 'medical_info',
        'special_accommodations', 'payment_amount', 'payment_date',
        'receipt_number', 'payment_method'
    ];
}