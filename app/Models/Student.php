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
        'track_id',
        'studentid',
        'strand_id',
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
        'payment_date',
        'downpayment',
        'payment_method',
        'balance',
        'receiptnumber',
        // 'section_id',
    ];

    // Relationships remain the same
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id');
    }

    public function track()
    {
        return $this->belongsTo(Tracks::class, 'track_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function sectionLines()
    {
        return $this->hasMany(SectionLine::class, 'student_id');
    }

    public function studentSubject()
    {
        return $this->hasMany(StudentSubject::class, 'student_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id')
            ->withPivot('grade', 'status', 'school_year');
    }
}
