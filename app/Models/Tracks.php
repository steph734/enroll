<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracks extends Model

{
    protected $table = 'tracks';
    protected $fillable = ['trackname', 'description'];

    public function strands()
    {
        return $this->belongsToMany(Strand::class, 'strand_track', 'track_id', 'strand_id');
    }
}
