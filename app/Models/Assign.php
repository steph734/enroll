<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    protected $table = 'assign';

    protected $fillable = [
        'teachername',
        'employmentstatus',
        'email',
        'section',
        'subject',
        'start_time',
        'end_time',
        'status',
    ];
}
