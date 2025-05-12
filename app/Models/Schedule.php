<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $table = 'schedule';
    protected $fillable = [
        'subject',
        'section',
        'grade_level',
        'day',
        'semester',
        'time',
        'room',
        'strand',
        'status',
        'teachername',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
