<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionLine extends Model
{
    protected $table = 'sectionline';

    protected $fillable = [
        'section_id',
        'student_id',
        'track_id',
        'strand_id',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
