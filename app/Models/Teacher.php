<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
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
        'degree',
        'major',
        'university',
        'year_graduated',
        'prc_license',
        'license_validity',
        'let_date',
        'specialization',
        'prc_copy',
        'previous_school',
        'position',
        'years_experience',
        'employment_status',
        'teaching_schedule',
        'subjects',
        'certifications',
        'medical_info',
        'accommodations',
        'resume',
        'transcript',
        'date_hired',
        'employee_id',
        'status'
    ];
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id');
    }

    public function track()
    {
        return $this->belongsTo(Tracks::class, 'track_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'student_id');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject', 'teacher_id', 'subject_id')
            ->withPivot('school_year', 'status');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // public function teacherSubject()
    // {
    //     return $this->hasMany(TeacherSubject::class, 'teacher_id','id');

    // }
    public function teacherSubject()
    {
        return $this->hasMany(TeacherSubject::class);
    }
}
