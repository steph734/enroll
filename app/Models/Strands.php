<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strands extends Model
{
    use HasFactory;
    protected $fillable = [
        'track_id',
        'strand_name',
        'description',
    ];

    public function track()
    {
        return $this->belongsTo(Tracks::class, 'track_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
