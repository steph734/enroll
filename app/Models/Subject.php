<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'subject_code',
        'subject_name',
        'description',
        'track_id',
        'strand_id',
        'grade_level',
        'semester',
        'term',
        'prerequisites',
    ];

    public function track()
    {
        return $this->belongsTo(Tracks::class, 'track_id');
    }
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'subject_id', 'student_id');
    }
    public function studentSubject()
    {
        return $this->belongsToMany(StudentSubject::class, 'student_subject_id');
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teachersubject', 'subject_id', 'teacher_id')
            ->withPivot('school_year', 'status');
    }
}
