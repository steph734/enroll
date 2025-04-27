<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'section';

    protected $fillable = [
        'sectioname',
        'gradelevel',
        'strandid',
        'code',
        'max_slots',
        'current_slots', // Add the new field
    ];
    public function strand()
    {
        return $this->belongsTo(Strand::class, 'strandid');
    }
    
    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
