<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
       'subject_name',
        'description',
        'track_id',
        'strand_id',

    ];

    public function track()
    {
        return $this->belongsTo(Tracks::class, 'track_id');
    }

    public function strand()
    {
        return $this->belongsTo(Strands::class, 'strand_id'); // Add relationship for strand
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'subject_id', 'student_id');
    }
}
