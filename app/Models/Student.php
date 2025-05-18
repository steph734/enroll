<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'home_address',
        'zip_code',
        'contact_number',
        'secondary_contact',
        'email',
        'guardian_first_name',
        'guardian_middle_name',
        'guardian_last_name',
        'relationship',
        'guardian_contact',
        'guardian_email',
        'previous_school',
        'grade_completed',
        'school_year_completed',
        'gpa',
        'transcript',
        'track_id',
        'strand_id',
        'grade_level',
        'class_schedule',
        'additional_notes',
        'medical_info',
        'special_accommodations',
        'payment_date',
        'downpayment',
        'payment_method',
        'balance',
        'receiptnumber',
        'studentid',
        'status',
        // 'section_id',
    ];

    // Add accessor for profile picture URL
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture && Storage::exists('public/' . $this->profile_picture)) {
            return Storage::url($this->profile_picture);
        }
        return null;
    }

    // Relationships
    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }
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
        return $this->hasMany(StudentSubject::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id')
            ->withPivot('grade', 'status', 'school_year');
    }
}
