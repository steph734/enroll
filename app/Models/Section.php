<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    protected $fillable = [
        'section_name',
        'description',
        'track_id',
        'strand_id',
        'grade_level',
        'school_year',
        'status',
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
        return $this->hasMany(Student::class, 'section_id');
    }
}
