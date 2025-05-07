<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Strand extends Model
{

    protected $table = 'strand';
    protected $fillable = ['name', 'description', 'track_id'];

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }
}
