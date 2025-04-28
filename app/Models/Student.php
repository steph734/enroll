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
        'studentid',
        'strand',
        'status',
        'class_schedule',
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
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relationship to fetch the latest payment
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
        return $this->belongsToMany(Student::class, 'section_student');
    }
}