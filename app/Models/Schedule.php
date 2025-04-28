<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $table = 'schedule';
    protected $fillable = [
        'subject_id',
        'section_id',
        'grade_level',
        'day',
        'semester',
        'time',
        'room',
        'strand',
        'status',
        'teachername',
    ];
}
