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
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function track()
    {
        return $this->belongsTo(Tracks::class, 'track_id');
    }
    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id');
    }
}
