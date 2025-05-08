<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tracks extends Model
{
    use HasFactory;
    protected $fillable = [
        'track_name',
        'description',
        'created_at',
        'updated_at',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function strands()
    {
        return $this->hasMany(Strands::class, 'track_id');
    }
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
