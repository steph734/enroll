<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strand extends Model
{

    protected $table = 'strand';
    protected $fillable = [
       'strandname', 'description', 'track'
    ];
}
