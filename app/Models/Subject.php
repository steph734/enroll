<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subjectname',
        'description',
        'gradelevel',
        'status',
        'start_time',
        'end_time',
    ];
}
