<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'section',
        'days',
        'term',
        'time',
        'room',
        'teacher_id', // Changed from teacher_name
        'strand_id',
        'status',
    ];

    public function strand()
    {
        return $this->belongsTo(Strands::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
